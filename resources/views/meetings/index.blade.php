@extends('layouts.app') {{-- Utilisez votre layout principal --}}

@section('title', 'Liste des Réunions')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Liste des Réunions</h1>

    <!-- Bouton pour créer une nouvelle réunion -->
    <a href="{{ route('meetings.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4 inline-block">
        <i class="fas fa-plus mr-2"></i> Créer une Réunion
    </a>

    <!-- Tableau des réunions -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">Titre</th>
                    <th class="px-4 py-2">Projet</th>
                    <th class="px-4 py-2">Organisateur</th>
                    <th class="px-4 py-2">Date de Début</th>
                    <th class="px-4 py-2">Date de Fin</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($meetings as $meeting)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $meeting->Title }}</td>
                        <td class="px-4 py-2">{{ $meeting->project->Title }}</td>
                        <td class="px-4 py-2">{{ $meeting->organizer->Username }}</td>
                        <td class="px-4 py-2">{{ $meeting->StartTime->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $meeting->EndTime->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('meetings.show', $meeting->MeetingID) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('meetings.edit', $meeting->MeetingID) }}" class="text-green-500 hover:text-green-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('meetings.destroy', $meeting->MeetingID) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réunion ?')">
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
@endsection