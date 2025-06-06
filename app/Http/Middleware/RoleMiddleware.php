<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->Role !== $role) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
} 