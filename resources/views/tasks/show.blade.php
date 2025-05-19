@extends('layouts.app')

@section('title', $task->Title)

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $task->Title }}</h1>
                    <p class="text-gray-600">{{ $task->Description }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('tasks.edit', $task->TaskID) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    <a href="{{ route('tasks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        <i class="fas fa-arrow-left mr-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Informations principales -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-4">Détails de la tâche</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Projet</label>
                        <p class="mt-1">{{ $task->project->Title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Statut</label>
                        <select class="mt-1 px-3 py-2 border rounded-md" onchange="updateTaskStatus(this)">
                            <option value="Pending" {{ $task->Status === 'Pending' ? 'selected' : '' }}>En attente</option>
                            <option value="In Progress" {{ $task->Status === 'In Progress' ? 'selected' : '' }}>En cours</option>
                            <option value="Completed" {{ $task->Status === 'Completed' ? 'selected' : '' }}>Terminée</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Priorité</label>
                        <span class="mt-1 inline-block px-2 py-1 rounded-full text-sm
                            @if($task->Priority === 'High') bg-red-100 text-red-800
                            @elseif($task->Priority === 'Medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ $task->Priority }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Date limite</label>
                        <p class="mt-1">{{ $task->DueDate->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-4">Progression</h2>
                <div class="bg-gray-100 rounded-lg p-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Avancement</label>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $task->CompletionPercentage }}%"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $task->CompletionPercentage }}% complété</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Heures estimées</label>
                            <p class="mt-1">{{ $task->EstimatedHours }}h</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Heures réelles</label>
                            <p class="mt-1">{{ $task->ActualHours ?? 'Non définies' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commentaires -->
        <div class="p-6 border-t">
            <h2 class="text-lg font-semibold mb-4">Commentaires</h2>
            <div class="space-y-4">
                @foreach($task->comments as $comment)
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">{{ $comment->user->Username }}</p>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $comment->Content }}</p>
                </div>
                @endforeach

                <!-- Formulaire de commentaire -->
                <form action="{{ route('tasks.comments.store', $task->TaskID) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <textarea name="Content" rows="3" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ajouter un commentaire..."></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateTaskStatus(select) {
        const taskId = '{{ $task->TaskID }}';
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
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            select.value = select.dataset.originalValue;
        });
    }
</script>
@endpush
@endsection 