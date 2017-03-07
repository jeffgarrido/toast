<?php

namespace App\Http\Controllers;

use App\Event;
use App\Student;
use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('student');
    }

    public function showStudentPage(){
        $students = Student::where('Account_Id', Auth::user()->id)->first();
        $organizations = $students->organizations()->get();

        return view('studentpages.dashboard', compact('organizations'));
    }

    public function showOrganization(Organization $organization){
        $orgs = $organization;

        $students = $orgs->students()->get();
//        dd($students);

        $events = Event::where('Organization_Id', $orgs->Organization_Id)->get();

        $lists = Student::where('Account_Id', Auth::user()->id)->first();
        $organizations = $lists->organizations()->get();




        return view('studentpages.orgpage', compact('organizations', 'events', 'orgs','students'));
    }


}
