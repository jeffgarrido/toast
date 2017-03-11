<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('studentpages.edit.addEvent', 'id');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $event = new Event();

        $event->Organization_Id = $id;
        $event->Event_Name = $request->input('Event_Name');
        $event->Description = $request->input('Description');
        $event->Event_Date = $request->input('Event_Date');
        $event->Start_Time = $request->input('Start_Time');
        $event->End_Time = $request->input('End_Time');
        $event->Venue = $request->input('Venue');

        $event->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function eventGuest(Event $event){
        $event = $event->load('students');
        $students = Student::all();
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
