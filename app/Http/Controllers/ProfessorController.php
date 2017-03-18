<?php

namespace App\Http\Controllers;

use App\AuditLog;
use App\Professor;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfessorController extends Controller
{
    private $nav = 'navManageUsers';

    function __construct()
    {
        $this->middleware('admin');

        View::share('nav', $this->nav);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professors = Professor::all();
        return view('admin.menu.manageProfessors', compact('professors'));
    }

    /**
     * Store a newly created professor and user account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $professor = new Professor();
        $professor->FirstName = $request->input('FirstName');
        $professor->MiddleName = $request->input('MiddleName', '');
        $professor->LastName = $request->input('LastName');
        $professor->Phone = $request->input('Phone');
        $professor->Email = $request->input('Email');
        $professor->Birthday = $request->input('Birthday');

//        dd($request->input('Email'));

        $user = new User();
        $user->name = $professor->Lastname . ', ' . $professor->FirstName . ' ' . $professor->Middlename;
        $user->email = $professor->Email;
        $user->password = bcrypt($professor->birthday);
        $user->Access_Level = 'Professor';
        $user->api_token = str_random(60);

        $user->save();

        $user->professor()->save($professor);

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
     * Display the specified resource.
     *
     * @param Professor $professor
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($id)
    {
        $professor = Professor::find($id);
        $courses = $professor->courses()->get();
//        dd($courses);

        return view('admin.show.showProfessor', compact('professor', 'courses', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $professor = Professor::find($id);
        return view('admin.edit.editProfessor', compact('professor'));
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
        $professor = Professor::find($id);
        $professor->update($request->all());
        $user = $professor->account()->first();
        $user->update(['name' => $professor->LastName . ', ' . $professor->FirstName . ' ' . $professor->MiddleName]);

        $this->createLog(
            'Update Professor',
            'Name: '.$professor->FirstName.' '.$professor->MiddleName.' '.$professor->LastName.                     '\n'.
            'Birthday: '.$professor->Birthday.  '\n'.
            'Phone: '.$professor->Phone.  '\n'.
            'Email: '.$professor->PersonalEmail.  '\n'
        );

        return redirect('/professors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $professor = Professor::find($id);

        $this->createLog(
            'Update Professor',
            'Name: '.$professor->FirstName.' '.$professor->MiddleName.' '.$professor->LastName.                     '\n'.
            'Birthday: '.$professor->Birthday.  '\n'.
            'Phone: '.$professor->Phone.  '\n'.
            'Email: '.$professor->PersonalEmail.  '\n'
        );

        $professor->delete();

        return back();
    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_Id = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }
}
