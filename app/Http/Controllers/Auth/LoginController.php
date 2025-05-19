<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required|string',
            'PasswordHash' => 'required|string',
        ]);

        $credentials = $request->only('Username', 'PasswordHash');

        if (Auth::attempt(['Username' => $credentials['Username'], 'password' => $credentials['PasswordHash']])) {
            $user = Auth::user();
            
            // Redirection en fonction du rôle
            switch ($user->Role) {
                case 'Admin':
                    return redirect()->route('admin.dashboard');
                case 'Client':
                    return redirect()->route('client.dashboard');
                case 'Freelancer':
                    return redirect()->route('freelancer.dashboard');
                default:
                    return redirect('/home');
            }
        }

        return back()->withErrors([
            'Username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
