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
<<<<<<< HEAD

=======
>>>>>>> 9b6c665695ef59ccfb9a8bbce5e107e8e5681909
        if($user && $user->Access_Level == 'Admin'){
            return $next($request);
        }elseif( Auth::guest() ) {
            return redirect('/login');
        }else{
            abort(503);
        }

    }
}
