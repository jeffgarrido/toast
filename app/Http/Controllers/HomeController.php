<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        if(Auth::user()->Access_Level == 'Student') {
            return view('studentpages.dashboard', compact('user'));
        }
        elseif (Auth::user()->Access_Level == 'Admin'){
            return view('home', compact('user'));
        }
    }
}
