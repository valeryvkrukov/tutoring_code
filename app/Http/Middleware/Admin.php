<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Admin
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
        // check if user is authenticated and has admin role
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // if temporary solution for 'sct_admin' session is still in place, check it as well
        if (session()->has('sct_admin')) {
            return $next($request);
        }

        // if not authenticated or not an admin, redirect to admin login page
        return redirect()->guest('admin/login');
    }
}
