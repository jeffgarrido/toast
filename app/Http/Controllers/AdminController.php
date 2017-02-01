<?php

namespace App\Http\Controllers;

use App\Section;
use App\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminRedirect(){
        $students = Student::all();
        return view('adminpages.studentpage', compact('students'));
    }

    public function showStudentPage(){
        $students = Student::all();
        return view('adminpages.studentpage', compact('students'));
    }

    public function showSectionsPage(){
        $sections = Section::all();
        return view('adminpages.sectionpage', compact('sections'));
    }
}
