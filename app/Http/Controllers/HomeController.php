<?php

namespace App\Http\Controllers;

use App\Professor;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Student;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        if(Auth::user()->Access_Level == 'Student') {

            $student = Student::where('Account_Id', Auth::user()->id)->first();

            $student->load('studentOutcomes');

            $organizations = $student->organizations()->get();

            return view('studentpages.menu.dashboard', compact('user', 'organizations', 'student'));
        }
        elseif (Auth::user()->Access_Level == 'Admin'){
            $nav = 'navAdminDashboard';
            return view('admin.menu.dashboard', compact('nav'));
        }
        elseif (Auth::user()->Access_Level == 'Professor'){
            $user = User::find(Auth::user()->id);
            $professor = $user->professor()->first();
            return view('professor.menu.dashboard', compact('professor'));

        }
    }
}
