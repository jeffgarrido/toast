<?php

namespace App\Http\Middleware;

use Closure;

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

        if($user && $user->Access_Level == 'Admin'){
            return $next($request);
        }

        abort(404, 'No way');
    }
}
