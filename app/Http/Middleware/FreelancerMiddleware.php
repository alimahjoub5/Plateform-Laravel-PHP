<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FreelancerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && strtolower(auth()->user()->Role) === 'freelancer') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Accès non autorisé');
    }
} 