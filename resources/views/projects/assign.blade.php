@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="bg-gray-800 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Affectation des freelancers</h1>
                        <p class="text-gray-300">Projet : {{ $project->Title }}</p>
                    </div>
                    <a href="{{ route('admin.projects.show', $project->ProjectID) }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour au projet
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulaire d'affectation -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('projects.assign', $project->ProjectID) }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">Sélectionner les freelancers</h2>
                    
                    @if($freelancers->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($freelancers as $freelancer)
                                <div class="border rounded-lg p-4 {{ $project->freelancers->contains($freelancer->UserID) ? 'bg-blue-50 border-blue-200' : 'bg-white' }}">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <input type="checkbox" 
                                                   name="freelancers[]" 
                                                   value="{{ $freelancer->UserID }}"
                                                   id="freelancer_{{ $freelancer->UserID }}"
                                                   class="form-checkbox h-5 w-5 text-blue-600 rounded"
                                                   {{ $project->freelancers->contains($freelancer->UserID) ? 'checked' : '' }}>
                                        </div>
                                        <div class="flex-1">
                                            <label for="freelancer_{{ $freelancer->UserID }}" class="block">
                                                <span class="font-medium text-gray-900">{{ $freelancer->Username }}</span>
                                                <span class="block text-sm text-gray-500">{{ $freelancer->Email }}</span>
                                            </label>
                                            @if($project->freelancers->contains($freelancer->UserID))
                                                <span class="inline-block mt-2 text-xs text-blue-600">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Déjà affecté
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Aucun freelancer disponible.</p>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.projects.show', $project->ProjectID) }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les affectations
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des freelancers actuellement affectés -->
        @if($project->freelancers->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
                <h2 class="text-xl font-semibold mb-4">Freelancers actuellement affectés</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($project->freelancers as $freelancer)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900">{{ $freelancer->Username }}</h3>
                            <p class="text-sm text-gray-500">{{ $freelancer->Email }}</p>
                            <p class="text-xs text-blue-600 mt-2">
                                Affecté le : {{ $freelancer->pivot->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 