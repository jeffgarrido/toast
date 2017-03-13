<?php

namespace App\Http\Controllers;

use App\Event;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $event = Event::where('Event_Id',$id)->with('organization')->first();
        return view('admin.edit.editEvent', compact('event'));
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
    {
        $uid = Auth::user()->id;
        $event = new Event();

        $event->Organization_Id = $id;
        $event->Event_Name = $request->input('Event_Name');
        $event->Description = $request->input('Description');
        $event->Event_Date = $request->input('Event_Date');
        $event->Start_Time = $request->input('Start_Time');
        $event->End_Time = $request->input('End_Time');
        $event->Venue = $request->input('Venue');
        if($uid == 'Student') $event->Status = "Pending";
        else $event->Status = "Approved";

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

    public function eventGuest($id){
        $event = Event::find($id);
        $event = $event->load('students');
        $students = Student::all();
        return view('admin.menu.manageGuestList', compact('students', 'event'));
    }

    public function populateGuestList(Event $event, Request $request) {
        dd($request);
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

    public function updateEvent($id,Request $request){
        $event = Event::where('Event_Id',$id)->with('organization')->first();
        $event->Organization_Id = $event->organization->Organization_Id;
        $event->update($request->all());
        return back();
    }
}
