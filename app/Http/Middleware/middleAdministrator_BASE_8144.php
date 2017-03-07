<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class middleAdministrator
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

        if($user && $user->access_level == 'Admin'){
            return $next($request);
        }elseif( Auth::guest() ) {
            return redirect('/login');
        }else{
            abort(503);
        }

    }
}
