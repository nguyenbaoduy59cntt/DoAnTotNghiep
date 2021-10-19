<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Employee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // var_dump(Auth::guard('employee')->check()); 
        // echo '<br>===========================';
        // var_dump(Auth::guard('admin')->check()); exit;
        if(Auth::guard('employee')->check() || Auth::guard('admin')->check())
        {
            return $next($request);
        }
        else
        {
            echo 'abcde';exit;
            return redirect('/admin/login');
        }
    }   
}
