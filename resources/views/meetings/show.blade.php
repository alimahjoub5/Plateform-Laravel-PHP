@extends('layouts.app')

@section('title', 'Détails de la Réunion')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Détails de la Réunion</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">{{ $meeting->Title }}</h2>
        <p class="text-gray-700 mb-4">{{ $meeting->Description }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <p class="text-sm text-gray-600">Projet : <span class="font-medium">{{ $meeting->project->Title }}</span></p>
                <p class="text-sm text-gray-600">Organisateur : <span class="font-medium">{{ $meeting->organizer->Username }}</span></p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Date de Début : <span class="font-medium">{{ $meeting->StartTime->format('d/m/Y H:i') }}</span></p>
                <p class="text-sm text-gray-600">Date de Fin : <span class="font-medium">{{ $meeting->EndTime->format('d/m/Y H:i') }}</span></p>
            </div>
        </div>

        <!-- Actions contextuelles -->
        <div class="flex flex-wrap gap-2 mb-4">
            <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-video mr-2"></i> Rejoindre la réunion
            </a>
            <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                <i class="fas fa-calendar-plus mr-2"></i> Ajouter à l'agenda
            </a>
            <a href="#" class="bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-600">
                <i class="fas fa-share-alt mr-2"></i> Partager
            </a>
        </div>

        <!-- Liste des participants -->
        <h3 class="text-lg font-bold mb-2">Participants</h3>
        <ul class="list-disc list-inside">
            @foreach($meeting->attendees as $attendee)
                <li class="text-sm text-gray-700">{{ $attendee->Username }}</li>
            @endforeach
        </ul>

        <!-- Pièces jointes -->
        <h3 class="text-lg font-bold mt-4 mb-2">Pièces jointes</h3>
        <div class="border rounded-md p-4">
            <p class="text-gray-500">Aucune pièce jointe pour le moment.</p>
        </div>
    </div>
</div>
@endsection