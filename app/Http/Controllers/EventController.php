<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Event;
use App\Student;
use Carbon\Carbon;
use Mockery\CountValidator\Exception;

class EventController extends Controller
{
    public function logAttendance(Event $event, $studentToken) {
        $guest = Student::where('StudentNumber', '=', $studentToken)->get()->first();
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

        $log->AccountID = 1;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
