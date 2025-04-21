@extends('layouts.app')

@section('title', 'Calendrier des Réunions')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Calendrier des Réunions</h1>

    <!-- Conteneur du calendrier -->
    <div id="calendar" class="bg-white shadow-md rounded-lg p-4"></div>
</div>

<!-- Script pour initialiser FullCalendar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Vue par défaut (mois)
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'fr', // Localisation en français
            events: '/meetings/calendar-data', // Endpoint pour récupérer les réunions
            eventClick: function(info) {
                // Rediriger vers la page des détails de la réunion
                window.location.href = `/meetings/${info.event.id}`;
            }
        });

        calendar.render();
    });
</script>
@endsection