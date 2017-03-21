<?php

namespace App\Http\Controllers;

use App\Professor;
use App\StudentOutcome;
use Carbon\Carbon;
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

            $outcomes = $student->studentOutcomes()->with(array(
                'events' => function($query) {
                    $query->where('Event_Date', '>', Carbon::today()->toDateString());
                },
            ))->get();

            $organizations = $student->organizations()->get();

            return view('studentpages.menu.dashboard', compact('user', 'organizations', 'student', 'outcomes'));
        }
        elseif (Auth::user()->Access_Level == 'Admin'){
            $nav = 'navAdminDashboard';
            $outcomes = StudentOutcome::with(array(
                'students' => function($query) {
                    $query->where('Evaluation', '>', 0)->where('Evaluation', '<=', 1);
                }, 'events' => function($query) {
                    $query->where('Event_Date', '>', Carbon::today()->toDateString());
                },
            ))->get();
            return view('admin.menu.dashboard', compact('nav', 'outcomes'));
        }
        elseif (Auth::user()->Access_Level == 'Professor'){
            $user = User::find(Auth::user()->id);
            $professor = $user->professor()->first();
            $outcomes = StudentOutcome::with(array(
                'students' => function($query) {
                    $query->where('Evaluation', '>', 0)->where('Evaluation', '<=', 1);
                }, 'events' => function($query) {
                    $query->where('Event_Date', '>', Carbon::today()->toDateString());
                },
            ))->get();

            return view('professor.menu.dashboard', compact('professor', 'outcomes'));

        }
    }
}
