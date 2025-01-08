@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Détails de l'Utilisateur</h1>

        <div class="space-y-4">
            <!-- Username -->
            <div>
                <label class="block text-gray-700">Username</label>
                <p class="mt-1 p-2 bg-gray-100 rounded-lg">{{ $user->Username }}</p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700">Email</label>
                <p class="mt-1 p-2 bg-gray-100 rounded-lg">{{ $user->Email }}</p>
            </div>

            <!-- Rôle -->
            <div>
                <label class="block text-gray-700">Rôle</label>
                <p class="mt-1 p-2 bg-gray-100 rounded-lg">{{ $user->Role }}</p>
            </div>

            <!-- Photo de profil -->
            <div>
                <label class="block text-gray-700">Photo de profil</label>
                @if ($user->ProfilePicture)
                    <img src="{{ asset('storage/' . $user->ProfilePicture) }}" alt="Photo de profil" class="mt-1 w-32 h-32 rounded-lg object-cover">
                @else
                    <p class="mt-1 p-2 bg-gray-100 rounded-lg">Aucune photo de profil</p>
                @endif
            </div>

            <!-- Bio -->
            <div>
                <label class="block text-gray-700">Bio</label>
                <p class="mt-1 p-2 bg-gray-100 rounded-lg">{{ $user->Bio ?? 'Non renseignée' }}</p>
            </div>

            <!-- Langue -->
            <div>
                <label class="block text-gray-700">Langue</label>
                <p class="mt-1 p-2 bg-gray-100 rounded-lg">{{ $user->Language }}</p>
            </div>
        </div>

        <!-- Bouton de retour -->
        <div class="mt-6">
            <a href="{{ route('users.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
                Retour à la liste
            </a>
        </div>
    </div>
@endsection