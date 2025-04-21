@extends('layouts.app')

@section('title', 'Modifier la Réunion')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Modifier la Réunion</h1>

    <form action="{{ route('meetings.update', $meeting->MeetingID) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <!-- Titre -->
        <div class="mb-4">
            <label for="Title" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="Title" id="Title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $meeting->Title }}" required>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="Description" id="Description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $meeting->Description }}</textarea>
        </div>

        <!-- Projet -->
        <div class="mb-4">
            <label for="ProjectID" class="block text-sm font-medium text-gray-700">Projet</label>
            <select name="ProjectID" id="ProjectID" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @foreach($projects as $project)
                    <option value="{{ $project->ProjectID }}" {{ $project->ProjectID == $meeting->ProjectID ? 'selected' : '' }}>{{ $project->Title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="StartTime" class="block text-sm font-medium text-gray-700">Date de Début</label>
                <input type="datetime-local" name="StartTime" id="StartTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $meeting->StartTime->format('Y-m-d\TH:i') }}" required>
            </div>
            <div>
                <label for="EndTime" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                <input type="datetime-local" name="EndTime" id="EndTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $meeting->EndTime->format('Y-m-d\TH:i') }}" required>
            </div>
        </div>

        <!-- Participants -->
        <div class="mb-4">
            <label for="attendees" class="block text-sm font-medium text-gray-700">Participants</label>
            <select name="attendees[]" id="attendees" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->UserID }}" {{ in_array($user->UserID, $meeting->attendees->pluck('UserID')->toArray()) ? 'selected' : '' }}>{{ $user->Username }}</option>
                @endforeach
            </select>
        </div>

        <!-- Bouton de soumission -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-save mr-2"></i> Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection