<?php

namespace App\Http\Controllers;

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
        $students = Student::all();

        return view('studentpages.dashboard');
    }

    public function showOrganization(){
        $students = Student::where('Account_Id', Auth::user()->id)->first();
        $organizations = $students->organizations()->get();

        return view('studentpages.orgpage', compact('organizations'));
    }


}
