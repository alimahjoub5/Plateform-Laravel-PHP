<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Trouver l'utilisateur par son nom d'utilisateur
        $user = \App\Models\User::where('Username', $request->Username)->first();

        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if ($user && Hash::check($request->PasswordHash, $user->PasswordHash)) {
            Auth::login($user);
            
            // Vérifier si l'email est vérifié
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('warning', 'Veuillez vérifier votre adresse email avant de vous connecter.');
            }
            
            // Redirection en fonction du rôle (insensible à la casse)
            switch (strtolower($user->Role)) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'client':
                    return redirect()->route('client.dashboard');
                case 'freelancer':
                    return redirect()->route('freelancer.dashboard');
                default:
                    return redirect('/home');
            }
        }

        return back()->withErrors([
            'Username' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
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
