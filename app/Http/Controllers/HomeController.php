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

            $this->updateStudentDashboard($student);

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

    private function updateStudentDashboard(Student $student) {

        $student->load(array(
            'events' => function ($query) {
                $query->where('event_student.Attendance', '<>', '');
            }
        ));

        foreach ($student->studentOutcomes()->with('performanceIndicators')->get() as $outcome) {
            $outcome->pivot->Evaluation = 0;
            $outcome->pivot->P1 = 0;
            $outcome->pivot->P2 = 0;
            $outcome->pivot->P3 = 0;
            $outcome->pivot->EventEval = 0;
            $p1ctr = 0;
            $p2ctr = 0;
            $p3ctr = 0;
            $eventCtr = 0;

            foreach ($student->SOEvaluations()->get() as $soEval) {
                if($soEval->pivot->Evaluation == 0){
                    continue;
                }
                $index = $outcome->performanceIndicators->search($soEval->performanceIndicator);
                if($index === false){
                    continue;
                } else {
                    switch ($index) {
                        case 0:
                            $outcome->pivot->P1 += $soEval->pivot->Evaluation;
                            $p1ctr++;
                            break;
                        case 1:
                            $outcome->pivot->P2 += $soEval->pivot->Evaluation;
                            $p2ctr++;
                            break;
                        case 2:
                            $outcome->pivot->P3 += $soEval->pivot->Evaluation;
                            $p3ctr++;
                            break;
                    }
                }
            }

            $outcome->pivot->P1 = round($outcome->pivot->P1 / (($p1ctr == 0) ? 1 : $p1ctr), 2);
            $outcome->pivot->P2 = round($outcome->pivot->P2 / (($p2ctr == 0) ? 1 : $p2ctr), 2);
            $outcome->pivot->P3 = round($outcome->pivot->P3 / (($p3ctr == 0) ? 1 : $p3ctr), 2);

            foreach ($student->events()->where('event_student.Attendance', '<>', '')->get() as $studentEvent) {
                if ($studentEvent->studentOutcomes()->get()->contains($outcome)) {
                    $eventCtr++;
                }
            }

            $eventScore = $eventCtr / (($outcome->Events_Minimum == 0) ? 1 : $outcome->Events_Minimum) * 100;

            if($eventCtr <= 0){
                $outcome->pivot->EventEval = 0;
            }elseif($eventScore < 40) {
                $outcome->pivot->EventEval = 1;
            } elseif ($eventScore < 60) {
                $outcome->pivot->EventEval = 2;
            }elseif ($eventScore < 80) {
                $outcome->pivot->EventEval = 3;
            }else {
                $outcome->pivot->EventEval = 4;
            }

            $outcome->pivot->Evaluation = round(
                (($outcome->pivot->P1 * $outcome->performanceIndicators[0]->Weight / 100) +
                    ($outcome->pivot->P2 * $outcome->performanceIndicators[1]->Weight / 100) +
                    ($outcome->pivot->P3 * $outcome->performanceIndicators[2]->Weight / 100) +
                    ($outcome->pivot->EventEval * $outcome->Event_Weight / 100)), 2);

            $outcome->pivot->update();
        }
    }
}
