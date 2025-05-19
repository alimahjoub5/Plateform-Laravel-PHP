@extends('layouts.app')

@section('title', 'Suivi du Temps')

@section('content')
<div class="container mx-auto p-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Carte du temps aujourd'hui -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Temps aujourd'hui</h2>
            <div class="text-3xl font-bold text-blue-600">
                {{ floor($totalTimeToday / 60) }}h {{ $totalTimeToday % 60 }}m
            </div>
        </div>

        <!-- Carte de la session active -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Session active</h2>
            <div id="active-session">
                <div class="text-gray-500">Aucune session active</div>
            </div>
        </div>

        <!-- Carte des statistiques de la semaine -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Cette semaine</h2>
            <div class="space-y-2">
                @foreach($weekStats as $date => $minutes)
                    <div class="flex justify-between items-center">
                        <span>{{ \Carbon\Carbon::parse($date)->format('d/m') }}</span>
                        <span class="font-medium">{{ floor($minutes / 60) }}h {{ $minutes % 60 }}m</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Formulaire de démarrage de session -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Démarrer une session</h2>
        <form id="start-session-form" class="space-y-4">
            @csrf
            <div>
                <label for="TaskID" class="block text-sm font-medium text-gray-700">Tâche</label>
                <select name="TaskID" id="TaskID" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">Sélectionner une tâche</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->TaskID }}">{{ $task->Title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="Description" id="Description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Démarrer la session
                </button>
                <button type="button" id="stop-session" class="hidden bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 ml-2">
                    Arrêter la session
                </button>
            </div>
        </form>
    </div>

    <!-- Historique des sessions -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Sessions d'aujourd'hui</h2>
        <div class="space-y-4">
            @foreach($todayTracking as $tracking)
                <div class="border-b pb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">{{ $tracking->task->Title }}</h3>
                            <p class="text-sm text-gray-500">{{ $tracking->Description }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($tracking->StartTime)->format('H:i') }} - 
                                {{ $tracking->EndTime ? \Carbon\Carbon::parse($tracking->EndTime)->format('H:i') : 'En cours' }}
                            </div>
                            @if($tracking->EndTime)
                                <div class="font-medium">
                                    {{ floor(\Carbon\Carbon::parse($tracking->EndTime)->diffInMinutes($tracking->StartTime) / 60) }}h 
                                    {{ \Carbon\Carbon::parse($tracking->EndTime)->diffInMinutes($tracking->StartTime) % 60 }}m
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Vérifier la session active au chargement
    function checkActiveSession() {
        fetch('/time-tracking/active-session')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.tracking) {
                    updateActiveSession(data.tracking);
                }
            });
    }

    // Mettre à jour l'affichage de la session active
    function updateActiveSession(tracking) {
        const activeSessionDiv = document.getElementById('active-session');
        const startButton = document.querySelector('#start-session-form button[type="submit"]');
        const stopButton = document.getElementById('stop-session');

        activeSessionDiv.innerHTML = `
            <div class="space-y-2">
                <div class="font-medium">${tracking.task.Title}</div>
                <div class="text-sm text-gray-500">${tracking.Description}</div>
                <div class="text-sm text-gray-500">
                    Début: ${new Date(tracking.StartTime).toLocaleTimeString()}
                </div>
            </div>
        `;

        startButton.classList.add('hidden');
        stopButton.classList.remove('hidden');
    }

    // Démarrer une session
    document.getElementById('start-session-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/time-tracking/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                TaskID: formData.get('TaskID'),
                Description: formData.get('Description')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateActiveSession(data.tracking);
                this.reset();
            } else {
                alert(data.message);
            }
        });
    });

    // Arrêter une session
    document.getElementById('stop-session').addEventListener('click', function() {
        fetch('/time-tracking/stop', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        });
    });

    // Vérifier la session active au chargement
    checkActiveSession();
</script>
@endpush
@endsection 