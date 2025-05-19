@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6">
                <h1 class="text-2xl font-bold">Créer une nouvelle tâche</h1>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Titre -->
                <div class="mb-4">
                    <label for="Title" class="block text-sm font-medium text-gray-700">Titre</label>
                    <input type="text" name="Title" id="Title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="Description" id="Description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                </div>

                <!-- Projet -->
                <div class="mb-4">
                    <label for="ProjectID" class="block text-sm font-medium text-gray-700">Projet</label>
                    <select name="ProjectID" id="ProjectID" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Sélectionner un projet</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->ProjectID }}">{{ $project->Title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Développeur assigné -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Développeur assigné</label>
                    <div class="flex overflow-x-auto pb-4 space-x-4">
                        @foreach($developers as $developer)
                        <div class="flex-none w-64">
                            <input type="radio" name="AssignedTo" id="developer_{{ $developer->UserID }}" value="{{ $developer->UserID }}" class="hidden peer" required>
                            <label for="developer_{{ $developer->UserID }}" class="block p-4 border rounded-lg cursor-pointer hover:shadow-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-300">
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-3">
                                        @if($developer->ProfilePicture)
                                            <img src="{{ asset('storage/' . $developer->ProfilePicture) }}" alt="{{ $developer->FirstName }}" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg">
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center border-4 border-white shadow-lg">
                                                <span class="text-2xl font-bold text-white">{{ substr($developer->FirstName, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $developer->FirstName }} {{ $developer->LastName }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $developer->Role }}</p>
                                    <div class="mt-3 w-full">
                                        <div class="h-1 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500 rounded-full transform scale-x-0 peer-checked:scale-x-100 transition-transform duration-300"></div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Priorité -->
                <div class="mb-4">
                    <label for="Priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                    <select name="Priority" id="Priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="Low">Basse</option>
                        <option value="Medium" selected>Moyenne</option>
                        <option value="High">Haute</option>
                        <option value="Urgent">Urgente</option>
                    </select>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="StartDate" class="block text-sm font-medium text-gray-700">Date de début</label>
                        <input type="date" name="StartDate" id="StartDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="DueDate" class="block text-sm font-medium text-gray-700">Date limite</label>
                        <input type="date" name="DueDate" id="DueDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <!-- Temps estimé -->
                <div class="mb-6">
                    <label for="EstimatedHours" class="block text-sm font-medium text-gray-700">Temps estimé (heures)</label>
                    <input type="number" name="EstimatedHours" id="EstimatedHours" min="0" step="0.5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('tasks.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-300">
                        Annuler
                    </a>
                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-300">
                        Créer la tâche
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Définir la date de début par défaut à aujourd'hui
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('StartDate').value = today;

        // Validation de la date limite
        document.getElementById('DueDate').addEventListener('change', function() {
            const startDate = new Date(document.getElementById('StartDate').value);
            const dueDate = new Date(this.value);

            if (dueDate < startDate) {
                alert('La date limite doit être postérieure à la date de début.');
                this.value = '';
            }
        });
    });
</script>
@endpush
@endsection 