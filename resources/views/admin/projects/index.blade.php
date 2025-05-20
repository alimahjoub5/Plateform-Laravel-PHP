@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- En-tête -->
        <div class="bg-blue-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-white">Gestion des projets</h1>
                <a href="{{ route('projects.create') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau projet
                </a>
            </div>
        </div>

        <!-- Contenu -->
        <div class="p-6">
            @if ($projects->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-project-diagram text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Aucun projet n'a été trouvé</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date limite</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approbation</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($projects as $project)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $project->Title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $project->client->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">${{ number_format($project->Budget, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($project->Deadline)->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($project->Status === 'Pending') bg-yellow-100 text-yellow-800
                                            @elseif($project->Status === 'In Progress') bg-blue-100 text-blue-800
                                            @elseif($project->Status === 'Completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $project->Status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($project->ApprovalStatus === 'Approved') bg-green-100 text-green-800
                                            @elseif($project->ApprovalStatus === 'Rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $project->ApprovalStatus }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.projects.show', $project->ProjectID) }}" 
                                           class="inline-flex items-center px-3 py-1 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition duration-200">
                                            <i class="fas fa-eye mr-1"></i>
                                            Voir
                                        </a>
                                        
                                        @if ($project->ApprovalStatus === 'Pending')
                                            <form action="{{ route('admin.projects.approve', $project->ProjectID) }}" 
                                                  method="POST" 
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-green-600 text-green-600 rounded-md hover:bg-green-50 transition duration-200">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Approuver
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.projects.reject', $project->ProjectID) }}" 
                                                  method="POST" 
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-600 text-red-600 rounded-md hover:bg-red-50 transition duration-200">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Refuser
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection