@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Créer un nouveau projet</h1>
                <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>Retour aux projets
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Des erreurs sont survenues</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Champs cachés pour les valeurs par défaut -->
                <input type="hidden" name="ClientID" value="{{ auth()->user()->UserID }}">
                <input type="hidden" name="Status" value="Pending">
                <input type="hidden" name="ApprovalStatus" value="Pending">

                <!-- Titre du projet -->
                <div>
                    <label for="Title" class="block text-sm font-medium text-gray-700">Titre du projet</label>
                    <input type="text" name="Title" id="Title" value="{{ old('Title') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                </div>

                <!-- Description -->
                <div>
                    <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="Description" id="Description" rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>{{ old('Description') }}</textarea>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="StartDate" class="block text-sm font-medium text-gray-700">Date de début</label>
                        <input type="date" name="StartDate" id="StartDate" value="{{ old('StartDate') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="Deadline" class="block text-sm font-medium text-gray-700">Date limite</label>
                        <input type="date" name="Deadline" id="Deadline" value="{{ old('Deadline') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                <!-- Budget -->
                <div>
                    <label for="Budget" class="block text-sm font-medium text-gray-700">Budget estimé (€)</label>
                    <input type="number" name="Budget" id="Budget" value="{{ old('Budget') }}" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                </div>

                <!-- Type de projet -->
                <div>
                    <label for="Type" class="block text-sm font-medium text-gray-700">Type de projet</label>
                    <select name="Type" id="Type" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="">Sélectionnez un type</option>
                        <option value="Web" {{ old('Type') == 'Web' ? 'selected' : '' }}>Site Web</option>
                        <option value="Mobile" {{ old('Type') == 'Mobile' ? 'selected' : '' }}>Application Mobile</option>
                        <option value="Desktop" {{ old('Type') == 'Desktop' ? 'selected' : '' }}>Application Desktop</option>
                        <option value="E-commerce" {{ old('Type') == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                        <option value="Autre" {{ old('Type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <!-- Priorité -->
                <div>
                    <label for="Priority" class="block text-sm font-medium text-gray-700">Priorité</label>
                    <select name="Priority" id="Priority" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="">Sélectionnez une priorité</option>
                        <option value="Basse" {{ old('Priority') == 'Basse' ? 'selected' : '' }}>Basse</option>
                        <option value="Moyenne" {{ old('Priority') == 'Moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="Haute" {{ old('Priority') == 'Haute' ? 'selected' : '' }}>Haute</option>
                        <option value="Urgente" {{ old('Priority') == 'Urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>

                <!-- Fonctionnalités requises -->
                <div>
                    <label for="Requirements" class="block text-sm font-medium text-gray-700">Fonctionnalités requises</label>
                    <textarea name="Requirements" id="Requirements" rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Listez les fonctionnalités principales de votre projet...">{{ old('Requirements') }}</textarea>
                </div>

                <!-- Notes supplémentaires -->
                <div>
                    <label for="Notes" class="block text-sm font-medium text-gray-700">Notes supplémentaires</label>
                    <textarea name="Notes" id="Notes" rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Ajoutez des informations complémentaires...">{{ old('Notes') }}</textarea>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('projects.index') }}" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Annuler
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Créer le projet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validation des dates
    document.getElementById('StartDate').addEventListener('change', function() {
        const deadline = document.getElementById('Deadline');
        if (this.value > deadline.value) {
            deadline.value = this.value;
        }
    });

    document.getElementById('Deadline').addEventListener('change', function() {
        const startDate = document.getElementById('StartDate');
        if (this.value < startDate.value) {
            alert('La date limite ne peut pas être antérieure à la date de début');
            this.value = startDate.value;
        }
    });

    // Validation du budget
    document.getElementById('Budget').addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
        }
    });
</script>
@endpush
@endsection 