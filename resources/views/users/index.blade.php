@extends('layouts.app')

@section('content')
    <div class="animate-fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Liste des Utilisateurs</h1>
        <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
            Créer un Utilisateur
        </a>

        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->UserID }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->Username }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->Email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->Role }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('users.show', $user->UserID) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-sm transition duration-200 ease-in-out transform hover:scale-105">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    <a href="{{ route('users.edit', $user->UserID) }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm transition duration-200 ease-in-out transform hover:scale-105">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded-full text-sm transition duration-200 ease-in-out transform hover:scale-105">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection