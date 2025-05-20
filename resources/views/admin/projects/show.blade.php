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
                </div>
            </div>
        </div>

        <!-- Actions Admin -->
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold mb-4">Actions Administrateur</h2>
            <div class="flex flex-wrap gap-4">
                @if($project->ApprovalStatus === 'Pending')
                    <form action="{{ route('admin.projects.approve', $project->ProjectID) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                            <i class="fas fa-check mr-2"></i>
                            Approuver le projet
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.projects.reject', $project->ProjectID) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white font-bold rounded">
                            <i class="fas fa-times mr-2"></i>
                            Refuser le projet
                        </button>
                    </form>
                @endif

                <a href="{{ route('projects.assign', $project->ProjectID) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                    <i class="fas fa-users mr-2"></i>
                    Gérer les freelancers
                </a>
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

            <!-- Freelancers affectés -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Freelancers affectés</h2>
                
                @if($project->freelancers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($project->freelancers as $freelancer)
                            <div class="bg-white rounded-lg shadow p-4">
                                <h3 class="font-medium">{{ $freelancer->Username }}</h3>
                                <p class="text-gray-600">{{ $freelancer->Email }}</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    Affecté le : {{ $freelancer->pivot->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Aucun freelancer n'est actuellement affecté à ce projet.</p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('projects.assign', $project->ProjectID) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                        <i class="fas fa-users mr-2"></i>
                        Gérer les affectations
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection