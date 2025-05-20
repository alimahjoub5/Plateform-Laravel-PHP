<!-- resources/views/auth/register.blade.php -->
@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->
        <div class="text-center">
            <a href="{{ route('register') }}" class="text-3xl font-bold text-blue-600">Mon Application</a>
        </div>

        <!-- Carte de connexion -->
        <div class="mt-8 bg-white py-8 px-6 shadow rounded-lg sm:px-10">
            <h2 class="text-center text-3xl font-bold text-gray-900 mb-6">
                Connexion
            </h2>

            @if(session('warning'))
                <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('warning') }}
                </div>
            @endif

            <form class="mt-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Champ Username -->
                <div class="mb-6">
                    <label for="Username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input id="Username" name="Username" type="text" autocomplete="username" required
                            class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Username') border-red-500 @enderror"
                            value="{{ old('Username') }}">
                        @error('Username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Champ Mot de passe -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bouton de connexion -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </button>
                </div>

                <!-- Lien d'inscription -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Vous n'avez pas de compte ?
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition duration-150 ease-in-out">
                            Inscrivez-vous
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection