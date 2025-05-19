<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->Role, $roles)) {
            if ($user->Role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->Role === 'client') {
                return redirect()->route('client.dashboard');
            } else {
                return redirect()->route('freelancer.dashboard');
            }
        }

        return $next($request);
    }
} 