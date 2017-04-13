<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IsConfirmedUser
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
        if (Auth::user() &&  Auth::user()->confirmed == 1) {
            return $next($request);
        }

        flash('Šį veiksmą gali atlikti tik patvirtinti vartotojai', 'danger');
        return Redirect::back();
    }
}
