<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            if(Auth::user()->Access_Level == 'Admin'){
                $admin = User::find(Auth::user()->id);
                return view('admin.menu.manageAccount',compact('admin'));

            }elseif (Auth::user()->Access_Level == 'Student'){
                $user = User::find(Auth::user()->id);
                $student = $user->student;
                $organizations = $student->organizations;
                return view('studentpages.menu.manageAccount',compact('student','organizations','user'));
            }
        }catch (\Exception $ex){

        }
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
        $user = User::where('id',$request->input('invisible'))->first();

        if($user->Access_Level == 'Admin'){
            if($request->input('pass') == $request->input('pass2')){
                $message = "Success! Password edited.";
                $user->password = bcrypt($request->input('pass2'));
                $user->update();
                return Redirect::back()->withErrors([$message]);
            }
        }
        elseif ($user->Access_Level == 'Student'){
            if(!empty($request->input('pass')) && !empty($request->input('pass2'))){
                if($request->input('pass') == $request->input('pass2')){
                    $student = $user->student;
                    $student->PersonalEmail = $request->input('email');
                    $student->Phone = $request->input('phone');
                    $student->update();

                    $user->password = bcrypt($request->input('pass'));
                    $user->update();
                    $message = "Successful changes made.";
                    return Redirect::back()->withErrors([$message]);
                }
                else{
                    $message = "Failed to save. Password does not match!";
                    return Redirect::back()->withErrors([$message]);
                }
            }
            else{
                $student = $user->student;
                $student->PersonalEmail = $request->input('email');
                $student->Phone = $request->input('phone');
                $student->update();
                $message = "Successful changes made.";
                return Redirect::back()->withErrors([$message]);
            }
        }

        return Redirect::back();

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
}
