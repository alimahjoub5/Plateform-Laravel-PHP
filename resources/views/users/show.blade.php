@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Détails de l'Utilisateur</h1>
            <div class="flex space-x-4">
                <a href="{{ route('users.edit', $user->UserID) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Informations principales -->
            <div class="space-y-6">
                <!-- Photo de profil -->
                <div class="flex justify-center">
                    @if ($user->ProfilePicture)
                        <img src="{{ asset('storage/' . $user->ProfilePicture) }}" alt="Photo de profil" class="w-48 h-48 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                    @else
                        <div class="w-48 h-48 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-200 shadow-lg">
                            <i class="fas fa-user text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Informations de base -->
                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Username</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->Username }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->Email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Rôle</label>
                        <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold
                            {{ $user->Role === 'Admin' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $user->Role === 'Developer' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $user->Role === 'Freelancer' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $user->Role === 'Client' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ $user->Role }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500">Langue</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->Language }}</p>
                    </div>
                </div>
            </div>

            <!-- Bio et informations supplémentaires -->
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bio</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $user->Bio ?? 'Aucune bio disponible' }}</p>
                </div>

                <!-- Statistiques (à personnaliser selon vos besoins) -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-blue-800">Projets complétés</h3>
                        <p class="mt-1 text-2xl font-bold text-blue-900">0</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-green-800">Note moyenne</h3>
                        <p class="mt-1 text-2xl font-bold text-green-900">0.0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions supplémentaires -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex justify-end space-x-4">
                <form action="{{ route('users.destroy', $user->UserID) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection