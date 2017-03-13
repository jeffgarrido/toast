<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Event;
use App\Organization;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $uid = Auth::user()->id;
        $org = Organization::find($id);

        $students = $org->students;
        $status = $org->students->where('Account_Id',$uid)->first()->pivot->Position;
        $events = $org->events;
        $count = 1;

        $organizations = Student::where('Account_Id', $uid)->first()->organizations()->get();

        if($status == 'Member') {

            return view('studentpages.menu.manageOrganizations', compact('org', 'organizations','status','events'));
        }
        elseif ($status == 'Staff'){

            return view('studentpages.menu.manageOrganizationsStaff', compact('organizations','org','status','events','students','count'));
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = Organization::find($id);
        return view('admin.edit.editOrganization', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::find($id);
        $organization->update($request->all());

        $this->createLog(
            'Update Organization',
            'Name: '.$organization->Organization_Name.                     '\n'.
            'Description: '.$organization->Description.  '\n'
        );
        return redirect('/organization');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showOrganization(){
        $organization = Organization::all();
        return view('organizationpages.orglist', compact('organization'));
    }

    public function getOrgDetails(Organization $organization){
        $events = $organization->events()->get();
        $students = $organization->students()->get();
        return view('organizationpages.orgdetails', compact('organization', 'events', 'students'));
    }

    public function getAttendanceList($id) {
        $event = Event::find($id);
        $students = $event->studentslist;
        return view('organizationpages.attendancelist', compact('event', 'students'));
    }

    public function downloadAttendanceList(Event $event) {
        $students = $event->students()->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(array('Student Number', 'Last Name', 'First Name', 'Time of Arrival'));

        foreach ($students as $student) {
            $csv->insertOne(array(
                $student->StudentNumber,
                $student->LastName,
                $student->FirstName,
                $student->pivot->created_at
            ));
        }

        $csv->output($event->Event_Date.'_'.$event->Event_Name.'.csv');
    }

    public function addOrg(Request $request){
        $org = new Organization();

        $org->Organization_Name = $request->input('Organization_Name');
        $org->Description = $request->input('Description');
        $org->Adviser_Id = $request->input('Adviser_Id');
        $org->save();

        //Create Audit Log
        $this->createLog(
            'Add Org',
            'Org Name: '.$request->input('Code').                                           '\n'.
            'Description: '.$request->input('Title').                                         '\n'.
            'Adviser ID: '.$request->input('Description', 'No Description Provided').  '\n'
        );

        return back();
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_ID = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }

    public function studentList(Organization $organization){
        $members = $organization->students()->get();
        $students = Student::all();
        $uid = Auth::user()->id;
        $orgs = Student::where('Account_Id', $uid)->first()->organizations()->get();

        return view('studentpages.edit.addMember',compact('organization','members','students','orgs'));
    }

    public function populateMemberList(Organization $organization, Request $request) {

        $organization->students()->sync($request->input('memberList', []));

        return back();
    }
}
