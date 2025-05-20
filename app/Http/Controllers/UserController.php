<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $users = User::orderBy('UserID', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */

     
     
     public function store(Request $request)
     {
         // Validation des données
         $validatedData = $request->validate([
             'Username' => 'required|string|max:50|unique:users',
             'Email' => 'required|email|max:100|unique:users',
             'PasswordHash' => 'required|string|min:8',
             'Role' => 'required|in:Developer,Client,Admin',
             'ProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
             'Bio' => 'nullable|string',
             'Language' => 'required|in:English,Spanish,French,German',
         ]);
         // Hasher le mot de passe
        $validatedData['PasswordHash'] = Hash::make($validatedData['PasswordHash']);
         // Gérer l'upload de l'image
         if ($request->hasFile('ProfilePicture')) {
             $imagePath = $request->file('ProfilePicture')->store('users', 'public'); // Stocke dans storage/app/public/users
             $validatedData['ProfilePicture'] = $imagePath; // Ajoute le chemin de l'image aux données validées
         }
     
         // Création de l'utilisateur
         User::create($validatedData);
     
         return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
     }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */


     public function update(Request $request, $id)
     {
         // Récupérer l'utilisateur à mettre à jour
         $user = User::findOrFail($id);
     
         // Validation des données
         $validatedData = $request->validate([
             'Username' => 'required|string|max:50|unique:users,Username,' . $user->UserID . ',UserID',
             'Email' => 'required|email|max:100|unique:users,Email,' . $user->UserID . ',UserID',
             'PasswordHash' => 'nullable|string|min:8', // Le mot de passe est facultatif
             'Role' => 'required|in:Developer,Client,Admin',
             'ProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'Bio' => 'nullable|string',
             'Language' => 'required|in:English,Spanish,French,German',
         ]);
     
         // Gérer l'upload de la nouvelle image de profil
         if ($request->hasFile('ProfilePicture')) {
             // Supprimer l'ancienne image si elle existe
             if ($user->ProfilePicture && Storage::disk('public')->exists($user->ProfilePicture)) {
                 Storage::disk('public')->delete($user->ProfilePicture);
             }
     
             // Stocker la nouvelle image
             $imagePath = $request->file('ProfilePicture')->store('users', 'public');
             $validatedData['ProfilePicture'] = $imagePath;
         }
     
         // Hasher le mot de passe si un nouveau mot de passe est fourni
         if (!empty($validatedData['PasswordHash'])) {
             $validatedData['PasswordHash'] = Hash::make($validatedData['PasswordHash']);
         } else {
             unset($validatedData['PasswordHash']); // Ne pas mettre à jour le mot de passe
         }
     
         // Mettre à jour l'utilisateur
         $user->update($validatedData);
     
         return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete(); // Supprime l'utilisateur
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
