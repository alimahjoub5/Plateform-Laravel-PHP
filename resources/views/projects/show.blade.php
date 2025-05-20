@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- En-tête du projet -->
        <div class="bg-gray-800 text-white p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $project->Title }}</h1>
                    <p class="text-gray-300">Client: {{ $project->client->FirstName }} {{ $project->client->LastName }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('projects.timeline', $project->ProjectID) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                        <i class="fas fa-history mr-2"></i> Timeline
                    </a>
                    <a href="{{ route('chat.index', $project->ProjectID) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">
                        <i class="fas fa-comments mr-2"></i> Chat
                    </a>
                </div>
            </div>
        </div>

        <!-- Timeline des étapes -->
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold mb-6">Étapes du projet</h2>
            <div class="relative">
                <!-- Ligne de progression -->
                <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 transform -translate-y-1/2"></div>
                
                <!-- Étapes -->
                <div class="relative flex justify-between">
                    <!-- Création du projet -->
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mb-2">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="text-sm font-medium">Création</span>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($project->created_at)->format('d/m/Y') }}</span>
                    </div>

                    <!-- Devis -->
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $project->devis->count() > 0 ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white mb-2">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <span class="text-sm font-medium">Devis</span>
                        <span class="text-xs text-gray-500">
                            @if($project->devis->count() > 0)
                                {{ $project->devis->count() }} devis
                                @if($project->devis->where('Statut', 'Accepté')->count() > 0)
                                    (Accepté)
                                @elseif($project->devis->where('Statut', 'Refusé')->count() > 0)
                                    (Refusé)
                                @else
                                    (En attente)
                                @endif
                            @else
                                En attente
                            @endif
                        </span>
                    </div>

                    <!-- Validation -->
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $project->ApprovalStatus === 'Approved' ? 'bg-green-500' : ($project->ApprovalStatus === 'Rejected' ? 'bg-red-500' : 'bg-gray-300') }} flex items-center justify-center text-white mb-2">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="text-sm font-medium">Validation</span>
                        <span class="text-xs text-gray-500">{{ $project->ApprovalStatus ?? 'En attente' }}</span>
                    </div>

                    <!-- Développement -->
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $project->Status === 'In Progress' ? 'bg-blue-500' : ($project->Status === 'Completed' ? 'bg-green-500' : 'bg-gray-300') }} flex items-center justify-center text-white mb-2">
                            <i class="fas fa-code"></i>
                        </div>
                        <span class="text-sm font-medium">Développement</span>
                        <span class="text-xs text-gray-500">{{ $project->Status ?? 'En attente' }}</span>
                    </div>

                    <!-- Livraison -->
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $project->Status === 'Completed' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white mb-2">
                            <i class="fas fa-flag-checkered"></i>
                        </div>
                        <span class="text-sm font-medium">Livraison</span>
                        <span class="text-xs text-gray-500">
                            @if($project->Status === 'Completed')
                                {{ \Carbon\Carbon::parse($project->updated_at)->format('d/m/Y') }}
                            @else
                                En attente
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations du projet -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Détails du projet</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-600">Description</label>
                            <p class="mt-1">{{ $project->Description }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-600">Budget</label>
                            <p class="mt-1">{{ number_format($project->Budget, 2) }} TND</p>
                        </div>
                        <div>
                            <label class="block text-gray-600">Date limite</label>
                            <p class="mt-1">
                                @if($project->Deadline)
                                    {{ \Carbon\Carbon::parse($project->Deadline)->format('d/m/Y') }}
                                @else
                                    Non définie
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-semibold mb-4">Statut</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-600">Statut du projet</label>
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-medium
                                @if($project->Status === 'Completed') bg-green-100 text-green-800
                                @elseif($project->Status === 'In Progress') bg-blue-100 text-blue-800
                                @elseif($project->Status === 'Pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $project->Status ?? 'Non défini' }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-gray-600">Statut d'approbation</label>
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-medium
                                @if($project->ApprovalStatus === 'Approved') bg-green-100 text-green-800
                                @elseif($project->ApprovalStatus === 'Rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $project->ApprovalStatus ?? 'En attente' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des devis -->
            @if($project->devis->count() > 0)
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Devis</h2>
                <div class="space-y-4">
                    @foreach($project->devis as $devis)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-medium">Devis #{{ $devis->Reference }}</h3>
                                <p class="text-sm text-gray-600">
                                    Émis le {{ \Carbon\Carbon::parse($devis->DateEmission)->format('d/m/Y') }}
                                    @if($devis->DateValidite)
                                        - Valide jusqu'au {{ \Carbon\Carbon::parse($devis->DateValidite)->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($devis->Statut === 'Accepté') bg-green-100 text-green-800
                                    @elseif($devis->Statut === 'Refusé') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $devis->Statut ?? 'En attente' }}
                                </span>
                                <a href="{{ route('devis.show', $devis->DevisID) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">
                            <p>Montant HT : {{ number_format($devis->TotalHT, 2) }} TND</p>
                            <p>TVA ({{ $devis->TVA }}%) : {{ number_format($devis->TotalHT * $devis->TVA / 100, 2) }} TND</p>
                            <p class="font-medium">Total TTC : {{ number_format($devis->TotalTTC, 2) }} TND</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Section des actions -->
            <div class="mt-8 border-t pt-6">
                <h2 class="text-xl font-semibold mb-4">Actions</h2>
                <div class="flex flex-wrap gap-4">
                    @if(auth()->user()->Role === 'Client' && $project->ClientID === auth()->user()->UserID)
                        @if($project->Status !== 'Cancelled' && $project->Status !== 'Completed')
                            <form action="{{ route('projects.cancel', $project->ProjectID) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white font-bold rounded">
                                    <i class="fas fa-ban mr-2"></i>
                                    Annuler le projet
                                </button>
                            </form>
                        @endif
                    @endif

                    <a href="{{ route('projects.timeline', $project->ProjectID) }}" 
                       class="inline-flex items-center px-4 py-2 bg-purple-500 hover:bg-purple-700 text-white font-bold rounded">
                        <i class="fas fa-history mr-2"></i>
                        Voir la timeline
                    </a>

                    <a href="{{ route('chat.index', $project->ProjectID) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                        <i class="fas fa-comments mr-2"></i>
                        Accéder au chat
                    </a>

                    @if($project->devis->count() > 0)
                        <a href="{{ route('devis.show', $project->devis->first()->DevisID) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-700 text-white font-bold rounded">
                            <i class="fas fa-file-invoice mr-2"></i>
                            Voir le devis
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 