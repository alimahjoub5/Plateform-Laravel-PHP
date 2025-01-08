<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire de profil.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Afficher la vue du profil avec les données de l'utilisateur
        return view('client.profile', compact('user'));
    }

    /**
     * Mettre à jour les informations du profil.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Validation des données
        $request->validate([
            'Username' => 'required|string|max:50|unique:users,Username,' . $user->UserID . ',UserID',
            'Email' => 'required|string|email|max:100|unique:users,Email,' . $user->UserID . ',UserID',
            'ProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'Bio' => 'nullable|string',
            'Language' => 'required|in:English,Spanish,French,German',
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->Username = $request->Username;
        $user->Email = $request->Email;
        $user->Bio = $request->Bio;
        $user->Language = $request->Language;

        // Gérer l'upload de la photo de profil
        if ($request->hasFile('ProfilePicture')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->ProfilePicture && Storage::disk('public')->exists($user->ProfilePicture)) {
                Storage::disk('public')->delete($user->ProfilePicture);
            }

            // Stocker la nouvelle photo
            $path = $request->file('ProfilePicture')->store('profile-pictures', 'public');
            $user->ProfilePicture = $path;
        }

        // Sauvegarder les modifications
        $user->save();

        // Rediriger vers la page de profil avec un message de succès
        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');
    }
}
