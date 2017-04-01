<?php

namespace App\Http\Controllers;

use App\Professor;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\AuditLog;
use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.menu.manageUsers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ngalan = $request->input('LastName'). ', '.  $request->input('FirstName'). ' '. $request->input('LastName');

        $user = new User();
        $user->name = $ngalan;
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->Access_Level = $request->input('Access_Level');
        $user->api_token = str_random(60);

        $user->save();

        $this->createLog(
            'Add User',
            'Name: '.$ngalan.  '\n'.
            'Email: '.$user->email.  '\n'.
            'Acces Level: '.$user->Access_Level.  '\n'
        );

        return Redirect::back()->withErrors(['Successfully added a new admin account!!']);
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
        $user = User::find($id);
        return view('admin.edit.editUser', compact('user'));
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
        $user = User::find($id);
        $user->update($request->all());

        $this->createLog(
            'Add User',
            'Name: '.$user->name.  '\n'.
            'Email: '.$user->email.  '\n'
        );

        return Redirect::back()->withErrors(["Update Successful."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $message = "Deletion of ".$user->name."'s account successful!'";
        $user->delete();
        return Redirect::back()->withErrors([$message]);



    }

    private function createLog($action, $description = ""){
        $log = new AuditLog();

        $log->Account_Id = Auth::user()->id;
        $log->Action = $action;
        $log->Description = $description;

        $log->save();
    }

    public function resetPass($id){
        $user = User::find($id);
        return view('admin.edit.resetUserPassword', compact('user'));
    }

    public function reset($id){
        $user = User::find($id);

        if($user->Access_Level == 'Admin') $user->password = bcrypt('admin');
        else if($user->Access_Level == 'Student'){
            $student = Student::where('Account_Id', $user->id)->first();
            $user->password = bcrypt($student->Birthday);
        }
        else if($user->Access_Level == 'Professor'){
            $prof = Professor::where('Account_Id', $user->id)->first();
            $user->password = bcrypt($prof->Birthday);
        }

        $user->update();
        return Redirect::back()->withErrors(['Reset Password Successful!']);
    }
}
