@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Modifier les informations de contact</h1>

    <form action="{{ route('dashboard.contact-info.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-semibold mb-2">Téléphone</label>
            <input type="text" name="phone" id="phone" class="w-full px-4 py-2 border rounded-lg" value="{{ $contactInfo->phone ?? '' }}" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">E-mail</label>
            <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg" value="{{ $contactInfo->email ?? '' }}" required>
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-semibold mb-2">Adresse</label>
            <input type="text" name="address" id="address" class="w-full px-4 py-2 border rounded-lg" value="{{ $contactInfo->address ?? '' }}" required>
        </div>

        <div class="mb-6">
            <!-- Label avec icône -->
            <label for="working_hours" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-clock mr-2 text-blue-600"></i> Heures de travail
            </label>
        
            <!-- Champ de saisie avec placeholder et effet au focus -->
            <input
                type="text"
                name="working_hours"
                id="working_hours"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                placeholder="Ex: Lundi - Vendredi : 9h - 18h"
                value="{{ $contactInfo->working_hours ?? '' }}"
                required
                aria-describedby="working_hours_help"
            >
        
            <!-- Message d'aide pour l'utilisateur -->
            <p id="working_hours_help" class="mt-2 text-sm text-gray-500">
                Indiquez les heures de travail (ex: "Lundi - Vendredi : 9h - 18h").
            </p>
        
            <!-- Message d'erreur en cas de validation échouée -->
            @error('working_hours')
                <p class="mt-2 text-sm text-red-600" role="alert">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="facebook_url" class="block text-gray-700 font-semibold mb-2">Facebook</label>
            <input type="url" name="facebook_url" id="facebook_url" class="w-full px-4 py-2 border rounded-lg" value="{{ $contactInfo->facebook_url ?? '' }}">
        </div>
        
        <div class="mb-4">
            <label for="twitter_url" class="block text-gray-700 font-semibold mb-2">Twitter</label>
            <input type="url" name="twitter_url" id="twitter_url" class="w-full px-4 py-2 border rounded-lg" value="{{ $contactInfo->twitter_url ?? '' }}">
        </div>
        
        <div class="mb-4">
            <label for="linkedin_url" class="block text-gray-700 font-semibold mb-2">LinkedIn</label>
            <input type="url" name="linkedin_url" id="linkedin_url" class="w-full px-4 py-2 border rounded-lg" value="{{ $contactInfo->linkedin_url ?? '' }}">
        </div>
        
        <div class="mb-4">
            <label for="instagram_url" class="block text-gray-700 font-semibold mb-2">Instagram</label>
            <input type="url" name="instagram_url" id="instagram_url" class="w-full px-4 py-2 border rounded-lg" value="{{ $contactInfo->instagram_url ?? '' }}">
        </div>
        
        <div class="text-center">
            <button type="submit" class="px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection