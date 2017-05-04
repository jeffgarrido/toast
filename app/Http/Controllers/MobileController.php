<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Organization;
use App\Student;
use Auth;
use App\Event;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MobileController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return Auth::user();
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /*
     * Fetch all organiations
     */
    public function getOrganizations() {
        return response()->json([
            'organizations' =>
                Organization::all()
        ]);
    }
    /*
     * Fetch all events
     */
    public function getEvents() {
        $events = Event::all();
        return response()->json([
            'events' => [
                $events->toArray()
            ]
        ]);
    }

    public function fetchStudent(Request $request) {
        $student = Student::where('StudentNumber', '=', $request->input('token'))->get()->load('studentOutcomes');

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

        return $student->toJson();
    }

    /*
     * Log a student for attendance to an event
     */
    public function logAttendance(Request $request) {
        $event = Event::findOrFail($request->input('event', 0));
        $guest = Student::where('StudentNumber', '=', $request->input('token', 0))->get()->first();

        try {
            if($guest == null) {
                return response()->json([
                    'attendance' => [
                        'status' => 'Unregistered user'
                    ]
                ]);
            }else{
                if($event->students()->wherePivot('Student_Id', '=' , $guest->Student_Id)->get()->first() != null) {
                    $pivot = $event->students()->wherePivot('Student_Id', '=', $guest->Student_Id)->get()->first()->pivot;
                    //dd($pivot);
                    $paymentStatus = $pivot->PaymentStatus;
                    if (strcasecmp($paymentStatus, 'Paid') == 0) {
                        $event->students()->updateExistingPivot($guest->Student_Id, array('Attendance' => Carbon::now('Asia/Singapore')));
                        $this->createLog("Update", "Updated Event " . $event->Event_Id . " Attendance Timestamp for student " . $guest->Student_Id);
                        return response()->json([
                            'attendance' => [
                                'status' => 'Welcome to ' . $event->Event_Name
                            ]
                        ]);
                    } else {
                        return response()->json([
                            'attendance' => [
                                'status' => 'Payment not yet settled.'
                            ]
                        ]);
                    }
                } else {
                    return response()->json([
                        'attendance' => [
                            'status' => 'Student not in the guest list.'
                        ]
                    ]);
                }
            }
        }catch (Exception $exception) {
            return response()->json([
                'attendance' => [
                    'status' => 'Error 404'
                ]
            ]);
        }
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_ID = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
