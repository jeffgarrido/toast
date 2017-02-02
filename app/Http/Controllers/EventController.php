<?php

namespace App\Http\Controllers;

use App\Event;
use App\Student;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class EventController extends Controller
{
    public function logAttendance(Event $event, Student $student) {
        try {
            $event->students()->save($student);
            return response()->json([
                'attendance' => [
                    'status' => true
                ]
            ]);
        }catch (Exception $exception) {
            return response()->json([
                'attendance' => [
                    'status' => false
                ]
            ]);
        }
    }
}
