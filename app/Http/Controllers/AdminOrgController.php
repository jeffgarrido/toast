<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Event;
use App\Organization;
use App\Professor;
use App\Student;
use App\StudentOutcome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminOrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = Organization::with('professors')->get();
        $profs = Professor::all();
        return view('admin.menu.manageOrganizations',compact('organizations','profs'));
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

        $organization = Organization::find($request->input('Organization_Id'))->first();
        $organization->update($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profs = Professor::all();
        $org = Organization::find($id)->first();
        $students = $org->students;
        $president = "";
        $vp = "";
        $tres = "";
        $sec = "";

        foreach ($students as $student)if($student->pivot->Position == 'President')$president = $student;
        foreach ($students as $student)if ($student->pivot->Position == 'Vice President')$vp = $student;
        foreach ($students as $student)if ($student->pivot->Position == 'Treasurer')$tres = $student;
        foreach ($students as $student)if ($student->pivot->Position == 'Secretary')$sec = $student;

        return view('admin.edit.editStaff', compact('students','president','vp','tres','sec','org','profs'));
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
        $announcement = new Announcement();
        $uid = Auth::user()->name;

        $announcement->Organization_Id = $id;
        $announcement->Title = $request->input('Title');
        $announcement->Announcement = $request->input('Announcement');
        $announcement->Uploaded_by = $uid;

        $announcement->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $org = Organization::find($id);
        $org->delete();


        return back();
    }

    public function showOrganization($id){
        $outcomes = StudentOutcome::all();
        $org = Organization::with('professors')->get()->find($id);
        $students = $org->students;
        $events = $org->events;
        $prof = $org->professors;
        $announcements = Announcement::where('Organization_Id', $id)->get();

        return view('admin.edit.editOrganizationHome', compact('$prof','org','events','students','outcomes','announcements'));
    }

    public function studentList(Organization $organization){
        $members = $organization->students()->get();

        $students = Student::all();
        $uid = Auth::user()->id;

        return view('admin.edit.addOrgMembers',compact('organization','members','students'));
    }

    public function populateMemberList(Organization $organization, Request $request) {

        $organization->students()->sync($request->input('memberList', []));

        return back();
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

        return Redirect::back()->withErrors(["A new organization has been added!"]);
    }

    public function updateStaff(Organization $organization,Request $request)
    {
        $organization->Adviser_Id = $request->input('Adviser');
        $organization->save();

        $president = $organization->students()->wherePivot('Position','=','President')->first();
        $vice = $organization->students()->wherePivot('Position','=','Vice President')->first();
        $treasurer = $organization->students()->wherePivot('Position','=','Treasurer')->first();
        $secretary = $organization->students()->wherePivot('Position','=','Secretary')->first();

        if($president) {
            $president->pivot->Position = 'Member';
            $president->pivot->update();
        }

        if($vice) {
            $vice->pivot->Position = 'Member';
            $vice->pivot->update();
        }

        if($treasurer) {
            $treasurer->pivot->Position = 'Member';
            $treasurer->pivot->update();
        }

        if($secretary) {
            $secretary->pivot->Position = 'Member';
            $secretary->pivot->update();
        }

        $student = $organization->students->where('Student_Id',$request->input('President'))->first();
        $student->pivot->Position = 'President';
        $student->pivot->update();

        $student = $organization->students->where('Student_Id',$request->input('Vice_President'))->first();
        $student->pivot->Position = 'Vice President';
        $student->pivot->update();

        $student = $organization->students->where('Student_Id',$request->input('Treasurer'))->first();
        $student->pivot->Position = 'Treasurer';
        $student->pivot->update();

        $student = $organization->students->where('Student_Id',$request->input('Secretary'))->first();
        $student->pivot->Position = 'Secretary';
        $student->pivot->update();


        return back();
    }
}
