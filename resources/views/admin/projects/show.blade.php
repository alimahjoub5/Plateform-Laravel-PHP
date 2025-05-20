@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- En-tête -->
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-white">Détails du projet</h1>
                <a href="{{ route('admin.projects') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>

        <!-- Contenu -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations principales -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations du projet</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-32 text-gray-600">Titre :</div>
                            <div class="flex-1 text-gray-900 font-medium">{{ $project->Title }}</div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-32 text-gray-600">Description :</div>
                            <div class="flex-1 text-gray-900">{{ $project->Description }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-32 text-gray-600">Client :</div>
                            <div class="flex-1 text-gray-900 font-medium">{{ $project->client->Username }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-32 text-gray-600">Budget :</div>
                            <div class="flex-1 text-gray-900 font-medium">${{ number_format($project->Budget, 2) }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-32 text-gray-600">Date limite :</div>
                            <div class="flex-1 text-gray-900 font-medium">{{ \Carbon\Carbon::parse($project->Deadline)->format('d/m/Y') }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-32 text-gray-600">Statut :</div>
                            <div class="flex-1">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($project->Status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($project->Status === 'In Progress') bg-blue-100 text-blue-800
                                    @elseif($project->Status === 'Completed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $project->Status }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-32 text-gray-600">Approbation :</div>
                            <div class="flex-1">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($project->ApprovalStatus === 'Approved') bg-green-100 text-green-800
                                    @elseif($project->ApprovalStatus === 'Rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $project->ApprovalStatus }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section d'affectation -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Gestion du projet</h2>
                    @if (!$project->ClientID)
                        <form action="{{ route('admin.projects.assign', $project->ProjectID) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Affecter à un utilisateur</label>
                                <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->UserID }}">{{ $user->Username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2"></i>
                                Affecter le projet
                            </button>
                        </form>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                <p class="text-blue-700">
                                    Ce projet est déjà affecté à <span class="font-semibold">{{ $project->client->Username }}</span>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection