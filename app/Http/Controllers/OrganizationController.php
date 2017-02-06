<?php

namespace App\Http\Controllers;

use App\Event;
use App\Organization;
use App\AuditLog;
use App\Student;
use Illuminate\Http\Request;
use League\Csv\Writer;

class OrganizationController extends Controller
{
    public function showOrganization(){
        $organization = Organization::all();
        return view('organizationpages.orglist', compact('organization'));
    }

    public function getOrgDetails(Organization $organization){
        $events = $organization->events()->get();
        $students = $organization->students()->get();
        return view('organizationpages.orgdetails', compact('organization', 'events', 'students'));
    }

    public function getAttendanceList(Event $event) {
        $student = Student::find(391)->get();
        dd($student);
        $students = $event->students()->wherePivot('Attendance', '!=', 'null')->get();
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

        $log->AccountID = 1;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}