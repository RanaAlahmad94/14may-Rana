<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {
            //assuming admin role id is 1
            if ((Auth::user()->roles()->where('role_id', '=', 1)->first()) == null) {
              // currently logged in user is not an admin
                // Auth::logout();
                return redirect('home');
            } else

                return $next($request);
        }

    else
    {
        return redirect('login');
    }
    }
}
