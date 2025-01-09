<!-- resources/views/auth/register.blade.php -->
@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-3xl font-bold text-blue-600">Mon Application</a>
        </div>

        <!-- Carte d'inscription -->
        <div class="mt-8 bg-white py-8 px-6 shadow rounded-lg sm:px-10">
            <h2 class="text-center text-3xl font-bold text-gray-900">
                Inscription
            </h2>

            <form class="mt-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Champ Username -->
                <div class="mb-6">
                    <label for="Username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                    <div class="mt-1">
                        <input id="Username" name="Username" type="text" autocomplete="username" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Username') border-red-500 @enderror"
                            value="{{ old('Username') }}">
                        @error('Username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Champ Email -->
                <div class="mb-6">
                    <label for="Email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                    <div class="mt-1">
                        <input id="Email" name="Email" type="email" autocomplete="email" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Email') border-red-500 @enderror"
                            value="{{ old('Email') }}">
                        @error('Email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Confirmation de l'Email -->
                <div class="mb-6">
                    <label for="Email_confirmation" class="block text-sm font-medium text-gray-700">Confirmez l'adresse email</label>
                    <div class="mt-1">
                        <input id="Email_confirmation" name="Email_confirmation" type="email" autocomplete="email" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Champ Password -->
                <div class="mb-6">
                    <label for="PasswordHash" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <div class="mt-1">
                        <input id="PasswordHash" name="PasswordHash" type="password" autocomplete="new-password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('PasswordHash') border-red-500 @enderror">
                        @error('PasswordHash')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Confirmation du Password -->
                <div class="mb-6">
                    <label for="PasswordHash_confirmation" class="block text-sm font-medium text-gray-700">Confirmez le mot de passe</label>
                    <div class="mt-1">
                        <input id="PasswordHash_confirmation" name="PasswordHash_confirmation" type="password" autocomplete="new-password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Bouton d'inscription -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        S'inscrire
                    </button>
                </div>

                <!-- Lien de connexion -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Connectez-vous
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection