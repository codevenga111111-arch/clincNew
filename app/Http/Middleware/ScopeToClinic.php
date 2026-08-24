<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ScopeToClinic
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->clinic_id) {
            view()->share('currentClinic', Auth::user()->clinic);
        }

        return $next($request);
    }
}
