<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->Role !== 'Admin') {
            abort(403, 'Accès non autorisé. Vous devez être administrateur.');
        }

        return $next($request);
    }
} 