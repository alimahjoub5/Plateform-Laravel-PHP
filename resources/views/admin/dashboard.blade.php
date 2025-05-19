@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-75">Total Projets</p>
                    <h3 class="text-2xl font-bold">{{ $totalProjects }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-project-diagram text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-75">Projets En Attente</p>
                    <h3 class="text-2xl font-bold">{{ $pendingProjects }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-75">Total Clients</p>
                    <h3 class="text-2xl font-bold">{{ $totalClients }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-75">Total Freelancers</p>
                    <h3 class="text-2xl font-bold">{{ $totalFreelancers }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-code text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Projects -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Projets Récents</h2>
                <div class="space-y-4">
                    @foreach($recentProjects as $project)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $project->Title }}</h3>
                                <p class="text-sm text-gray-500">Client: {{ $project->client->Username }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $project->Status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($project->Status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 
                                   ($project->Status === 'Completed' ? 'bg-green-100 text-green-800' : 
                                   'bg-gray-100 text-gray-800')) }}">
                                {{ $project->Status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Devis -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Devis Récents</h2>
                <div class="space-y-4">
                    @foreach($recentDevis as $devis)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $devis->project->Title }}</h3>
                                <p class="text-sm text-gray-500">Client: {{ $devis->client->Username }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">${{ number_format($devis->TotalTTC, 2) }}</p>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $devis->Statut === 'En attente' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($devis->Statut === 'Accepté' ? 'bg-green-100 text-green-800' : 
                                       'bg-red-100 text-red-800') }}">
                                    {{ $devis->Statut }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques du Site</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Visites Totales</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalVisits }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Utilisateurs Actifs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeUsers }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Appareil le Plus Utilisé</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $mostUsedDevice }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsectionTarget class [role] does not exist.
