@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- En-tête -->
        <div class="bg-gray-800 text-white p-6">
            <h1 class="text-2xl font-bold mb-2">Timeline du Projet</h1>
            <p class="text-gray-300">{{ $project->Title }}</p>
        </div>

        <!-- Timeline -->
        <div class="p-6">
            <div class="relative">
                <!-- Ligne verticale -->
                <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                <!-- Événements -->
                <div class="space-y-8">
                    @foreach($timeline as $event)
                    <div class="relative flex items-start">
                        <!-- Point sur la timeline -->
                        <div class="absolute left-6 -translate-x-1/2 w-4 h-4 rounded-full bg-{{ $event['color'] }}-500 border-4 border-white shadow-lg"></div>

                        <!-- Contenu de l'événement -->
                        <div class="ml-12 bg-gray-50 rounded-lg p-4 flex-1">
                            <div class="flex items-center mb-2">
                                <i class="fas {{ $event['icon'] }} text-{{ $event['color'] }}-500 mr-2"></i>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $event['title'] }}</h3>
                            </div>
                            <p class="text-gray-600 mb-2">{{ $event['description'] }}</p>
                            <span class="text-sm text-gray-500">
                                <i class="far fa-clock mr-1"></i>
                                {{ $event['date']->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="bg-gray-50 p-6 border-t">
            <div class="flex justify-between items-center">
                <a href="{{ route('projects.show', $project->ProjectID) }}" class="text-blue-500 hover:text-blue-600">
                    <i class="fas fa-arrow-left mr-2"></i> Retour au projet
                </a>
                <a href="{{ route('chat.index', $project->ProjectID) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                    <i class="fas fa-comments mr-2"></i> Ouvrir le chat
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-blue-500 { background-color: #3B82F6; }
    .bg-green-500 { background-color: #10B981; }
    .bg-red-500 { background-color: #EF4444; }
    .bg-yellow-500 { background-color: #F59E0B; }
    .bg-purple-500 { background-color: #8B5CF6; }
    .bg-indigo-500 { background-color: #6366F1; }
    
    .text-blue-500 { color: #3B82F6; }
    .text-green-500 { color: #10B981; }
    .text-red-500 { color: #EF4444; }
    .text-yellow-500 { color: #F59E0B; }
    .text-purple-500 { color: #8B5CF6; }
    .text-indigo-500 { color: #6366F1; }
</style>
@endpush
@endsection 