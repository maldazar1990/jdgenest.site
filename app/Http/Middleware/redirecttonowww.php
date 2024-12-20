<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;


class redirecttonowww
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (substr($request->header('host'), 0, 4) == 'www.') {

            $request->headers->set('host', config("app.domain"));



            return redirect()->to($request->path());

        }



        return $next($request);
    }
}
