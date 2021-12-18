<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Trainers
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
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        //Admin role = 2
        if(Auth::user()->account_type == 2) {
            return redirect()-route('admin');
        }

        //trainer role = 1
        if(Auth::user()->account_type == 1) {
            return $next($request);
        }

        //client role = 0
        if(Auth::user()->account_type == 0) {
            return redirect()-route('clients');
        }
    }
}
