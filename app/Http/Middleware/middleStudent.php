<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class middleStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if($user && ($user->Access_Level == 'Student' || $user->Access_Level == 'Admin')){
            return $next($request);
        }
        elseif( Auth::guest() ) {
            return redirect('/login');
        }
        else{
            abort(503);
        }
    }
}
