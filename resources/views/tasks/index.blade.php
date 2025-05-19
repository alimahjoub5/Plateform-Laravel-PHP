@extends('layouts.app')

@section('title', 'Mes Tâches')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Mes Tâches</h1>
        <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i>Nouvelle Tâche
        </a>
    </div>

    <!-- Filtres -->
    <div class="mb-6 flex flex-wrap gap-4">
        <div class="flex-1">
            <input type="text" id="search" placeholder="Rechercher une tâche..." class="w-full px-4 py-2 border rounded-md">
        </div>
        <select id="statusFilter" class="px-4 py-2 border rounded-md">
            <option value="all">Tous les statuts</option>
            <option value="Pending">En attente</option>
            <option value="In Progress">En cours</option>
            <option value="Completed">Terminées</option>
        </select>
        <select id="priorityFilter" class="px-4 py-2 border rounded-md">
            <option value="all">Toutes les priorités</option>
            <option value="High">Haute</option>
            <option value="Medium">Moyenne</option>
            <option value="Low">Basse</option>
        </select>
    </div>

    <!-- Liste des tâches -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($tasks as $task)
        <div class="bg-white rounded-lg shadow-md overflow-hidden task-card" 
             data-status="{{ $task->Status }}"
             data-priority="{{ $task->Priority }}"
             data-title="{{ strtolower($task->Title) }}">
            <div class="p-4">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold">{{ $task->Title }}</h3>
                    <span class="px-2 py-1 rounded-full text-sm
                        @if($task->Priority === 'High') bg-red-100 text-red-800
                        @elseif($task->Priority === 'Medium') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800
                        @endif">
                        {{ $task->Priority }}
                    </span>
                </div>
                
                <p class="text-gray-600 mb-4">{{ Str::limit($task->Description, 100) }}</p>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-project-diagram mr-2"></i>
                        Projet: {{ $task->project->Title }}
                    </p>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-calendar mr-2"></i>
                        Date limite: {{ $task->DueDate->format('d/m/Y') }}
                    </p>
                </div>

                <div class="flex justify-between items-center">
                    <select class="status-select px-2 py-1 rounded-md border text-sm" 
                            data-task-id="{{ $task->TaskID }}"
                            onchange="updateTaskStatus(this)">
                        <option value="Pending" {{ $task->Status === 'Pending' ? 'selected' : '' }}>En attente</option>
                        <option value="In Progress" {{ $task->Status === 'In Progress' ? 'selected' : '' }}>En cours</option>
                        <option value="Completed" {{ $task->Status === 'Completed' ? 'selected' : '' }}>Terminée</option>
                    </select>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('tasks.show', $task->TaskID) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('tasks.edit', $task->TaskID) }}" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    // Fonction pour mettre à jour le statut d'une tâche
    function updateTaskStatus(select) {
        const taskId = select.dataset.taskId;
        const status = select.value;

        fetch(`/tasks/${taskId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage si nécessaire
                const taskCard = select.closest('.task-card');
                taskCard.dataset.status = status;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            select.value = select.dataset.originalValue;
        });
    }

    // Filtrage des tâches
    document.getElementById('search').addEventListener('input', filterTasks);
    document.getElementById('statusFilter').addEventListener('change', filterTasks);
    document.getElementById('priorityFilter').addEventListener('change', filterTasks);

    function filterTasks() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const priorityFilter = document.getElementById('priorityFilter').value;

        document.querySelectorAll('.task-card').forEach(card => {
            const title = card.dataset.title;
            const status = card.dataset.status;
            const priority = card.dataset.priority;

            const matchesSearch = title.includes(searchTerm);
            const matchesStatus = statusFilter === 'all' || status === statusFilter;
            const matchesPriority = priorityFilter === 'all' || priority === priorityFilter;

            card.style.display = matchesSearch && matchesStatus && matchesPriority ? 'block' : 'none';
        });
    }
</script>
@endpush
@endsection 