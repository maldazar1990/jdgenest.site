<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Role
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
        $roles = array_slice(func_get_args(), 2);



        if ( Route::current()->uri != "admin/two-factor-challenge") {

            if (!Auth::user())
            {
                return redirect()->route('admin_login');
            }

            if (! Auth::user()->hasAnyRole($roles)) {
                throw new AuthorizationException("Tu n'as pas l'autorisation");
                Auth::logout();
                return redirect()->route('default');
            }
        }
        return $next($request);
    }
}
