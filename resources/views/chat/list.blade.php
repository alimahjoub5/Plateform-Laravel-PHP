@extends('layouts.app')

@section('title', 'Liste des Conversations')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Liste des Conversations</h1>

    <!-- Filtres et recherche -->
    <div class="mb-4 flex flex-wrap gap-4">
        <input type="text" id="search" placeholder="Rechercher par nom du client..." class="px-4 py-2 border rounded-md">
        <select id="statusFilter" class="px-4 py-2 border rounded-md">
            <option value="all">Toutes les conversations</option>
            <option value="active">Conversations actives</option>
            <option value="archived">Conversations archivées</option>
        </select>
    </div>

    <!-- Liste des conversations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($clients as $client)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-500 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold">{{ $client->Username }}</h3>
                                <p class="text-sm text-gray-500">{{ $client->Email }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-sm {{ $client->isOnline ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $client->isOnline ? 'En ligne' : 'Hors ligne' }}
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-600 mb-2">Projets en cours</h4>
                        <div class="space-y-2">
                            @forelse($client->projects as $project)
                                <div class="flex items-center justify-between bg-gray-50 p-2 rounded">
                                    <span class="text-sm">{{ $project->Title }}</span>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $project->Status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $project->Status }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Aucun projet en cours</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Dernier message: {{ $client->lastMessage ? $client->lastMessage->created_at->diffForHumans() : 'Aucun message' }}
                        </div>
                        <a href="{{ route('chat.show', $client->UserID) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                            <i class="fas fa-comments mr-2"></i>Discuter
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
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