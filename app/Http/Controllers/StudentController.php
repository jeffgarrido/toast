<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


}
