<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validation des données
        $request->validate([
            'Username' => 'required|string|max:50|unique:users',
            'Email' => 'required|string|email|max:100|unique:users',
            'PasswordHash' => 'required|string|min:8|confirmed',
            'ProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'Bio' => 'nullable|string',
            'Language' => 'nullable|in:English,Spanish,French,German',
        ]);

        // Création de l'utilisateur avec le rôle "Client"
        $user = User::create([
            'Username' => $request->Username,
            'Email' => $request->Email,
            'PasswordHash' => Hash::make($request->PasswordHash),
            'Role' => 'Client', // Rôle par défaut
            'ProfilePicture' => $request->hasFile('ProfilePicture') ? $request->file('ProfilePicture')->store('users', 'public') : null,
            'Bio' => $request->Bio,
            'Language' => $request->Language ?? 'English',
        ]);

        // Connecter l'utilisateur après l'inscription
        auth()->login($user);

        // Rediriger vers la page d'accueil
        return redirect('/home')->with('success', 'Inscription réussie !');
    }
}