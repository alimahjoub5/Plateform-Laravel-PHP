<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

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
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'PhoneNumber' => 'nullable|string|max:20',
            'Address' => 'nullable|string',
            'ProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'Bio' => 'nullable|string',
            'Language' => 'nullable|in:English,Spanish,French,German',
        ]);

        try {
            // Création de l'utilisateur avec le rôle "Client"
            $user = User::create([
                'Username' => $request->Username,
                'Email' => $request->Email,
                'PasswordHash' => Hash::make($request->PasswordHash),
                'FirstName' => $request->FirstName,
                'LastName' => $request->LastName,
                'PhoneNumber' => $request->PhoneNumber,
                'Address' => $request->Address,
                'Role' => 'Client', // Rôle par défaut
                'ProfilePicture' => $request->hasFile('ProfilePicture') ? $request->file('ProfilePicture')->store('users', 'public') : null,
                'Bio' => $request->Bio,
                'Language' => $request->Language ?? 'English',
            ]);

            Log::info('User created successfully', ['user_id' => $user->UserID, 'email' => $user->Email]);

            // Déclencher l'événement d'inscription qui enverra l'email de vérification
            event(new Registered($user));
            Log::info('Verification email sent', ['user_id' => $user->UserID]);

            // Connecter l'utilisateur après l'inscription
            auth()->login($user);

            // Rediriger vers la page de vérification
            return redirect()->route('verification.notice');
        } catch (\Exception $e) {
            Log::error('Error during user registration', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.']);
        }
    }
}