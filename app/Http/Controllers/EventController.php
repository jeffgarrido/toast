<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Event;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class EventController extends Controller
{
    public function eventGuest(Event $event){
        $students = Student::with('events')->get();
        return view('organizationpages.guestlist', compact('students', 'event'));
    }

    public function populateGuestList(Event $event, Request $request) {
        $event->students()->sync($request->input('students', []));

        return back();
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->AccountID = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
