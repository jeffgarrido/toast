<?php

namespace App\Http\Controllers;

use App\Event;
use App\Organization;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    private $nav = 'navManageUsers';

    public function __construct()
    {
        $this->middleware('student');

        View::share('nav', $this->nav);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return view('admin.menu.manageStudents', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $student = new Student();
        $student->FirstName = $request->input('FirstName');
        $student->MiddleName = $request->input('MiddleName', '');
        $student->LastName = $request->input('LastName');
        $student->Phone = $request->input('Phone');
        $student->Email = $request->input('Email');
        $student->Birthday = $request->input('Birthday');

//        dd($request->input('Email'));

        $user = new User();
        $user->name = $student->Lastname . ', ' . $student->FirstName . ' ' . $student->Middlename;
        $user->email = $student->Email;
        $user->password = bcrypt($student->birthday);
        $user->Access_Level = 'Professor';
        $user->api_token = str_random(60);

        $user->save();

        $user->student()->save($student);

        $this->createLog(
            'Add Professor',
            'Name: '.$request->input('FirstName').' '.$request->input('MiddleName').' '.$request->input('LastName').                     '\n'.
            'Birthday: '.$request->input('Birthday').  '\n'.
            'Phone: '.$request->input('Phone').  '\n'.
            'Email: '.$request->input('PersonalEmail').  '\n'
        );

        $this->createLog(
            'Add User',
            'name: ' . $user->name . '\n' .
            'email: ' . $user->email . '\n' .
            'password: ' . $user->getAuthPassword() . '\n' .
            'access level: ' . $user->Access_Level . '\n' .
            'api_token: ' . $user->api_token . '\n' .
            'Access_Level: ' . 'Student' . '\n'
        );

        return back();
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
        //
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
        //
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

    public function showStudentPage(){
        $students = Student::where('Account_Id', Auth::user()->id)->first();
        $organizations = $students->organizations()->get();

        return view('studentpages.dashboard', compact('organizations'));
    }

    public function showOrganization(Organization $organization){
        $orgs = $organization;

        $students = $orgs->students()->get();
//        dd($students);

        $events = Event::where('Organization_Id', $orgs->Organization_Id)->get();

        $lists = Student::where('Account_Id', Auth::user()->id)->first();
        $organizations = $lists->organizations()->get();




        return view('studentpages.orgpage', compact('organizations', 'events', 'orgs','students'));
    }
}
