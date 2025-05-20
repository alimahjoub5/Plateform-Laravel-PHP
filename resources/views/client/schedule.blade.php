@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mon Planning</h1>
        <div class="flex space-x-4">
            <button id="today" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                Aujourd'hui
            </button>
            <div class="flex space-x-2">
                <button id="prev" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="next" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div id="calendar" class="w-full"></div>
    </div>

    <!-- Modal pour les détails de l'événement -->
    <div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900" id="eventTitle"></h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="eventDate"></p>
                    <p class="text-sm text-gray-500 mt-2" id="eventDescription"></p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeModal" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: ''
        },
        locale: 'fr',
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour'
        },
        allDaySlot: false,
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        events: [
            // Les événements seront chargés dynamiquement depuis le backend
            @foreach($events as $event)
            {
                title: '{{ $event->title }}',
                start: '{{ $event->start_date }}',
                end: '{{ $event->end_date }}',
                description: '{{ $event->description }}',
                backgroundColor: '{{ $event->color }}',
                borderColor: '{{ $event->color }}'
            },
            @endforeach
        ],
        eventClick: function(info) {
            document.getElementById('eventTitle').textContent = info.event.title;
            document.getElementById('eventDate').textContent = 
                'Du ' + info.event.start.toLocaleString() + 
                ' au ' + info.event.end.toLocaleString();
            document.getElementById('eventDescription').textContent = info.event.extendedProps.description;
            document.getElementById('eventModal').classList.remove('hidden');
        }
    });
    calendar.render();

    // Navigation
    document.getElementById('today').addEventListener('click', function() {
        calendar.today();
    });
    document.getElementById('prev').addEventListener('click', function() {
        calendar.prev();
    });
    document.getElementById('next').addEventListener('click', function() {
        calendar.next();
    });

    // Fermeture du modal
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('eventModal').classList.add('hidden');
    });
});
</script>
@endpush
@endsection 