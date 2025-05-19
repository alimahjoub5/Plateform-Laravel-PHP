@extends('layouts.app')

@section('title', 'Liste des Clients')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Liste des Clients</h1>

    <!-- Bouton pour créer un nouveau client -->
    <a href="{{ route('clients.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4 inline-block">
        <i class="fas fa-plus mr-2"></i> Ajouter un Client
    </a>

    <!-- Filtres et recherche -->
    <div class="mb-4 flex flex-wrap gap-4">
        <input type="text" id="search" placeholder="Rechercher par nom, email ou téléphone..." class="px-4 py-2 border rounded-md">
        <select id="statusFilter" class="px-4 py-2 border rounded-md">
            <option value="all">Tous les clients</option>
            <option value="active">Clients actifs</option>
            <option value="inactive">Clients inactifs</option>
        </select>
    </div>

    <!-- Tableau des clients -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Téléphone</th>
                    <th class="px-4 py-2">Adresse</th>
                    <th class="px-4 py-2">Statut</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($clients as $client)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $client->Name }}</td>
                        <td class="px-4 py-2">{{ $client->Email }}</td>
                        <td class="px-4 py-2">{{ $client->Phone }}</td>
                        <td class="px-4 py-2">{{ $client->Address }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-sm {{ $client->Status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $client->Status ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('clients.show', $client->ClientID) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('clients.edit', $client->ClientID) }}" class="text-green-500 hover:text-green-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('clients.destroy', $client->ClientID) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function() {
        // Logique de recherche à implémenter
    });

    document.getElementById('statusFilter').addEventListener('change', function() {
        // Logique de filtrage par statut à implémenter
    });
</script>
@endsection 