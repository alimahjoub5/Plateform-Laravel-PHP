@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Mes Tâches</h1>
    </div>

    <!-- Liste des tâches -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tâche</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date limite</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tasks as $task)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $task->Title }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($task->Description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $task->project->Title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($task->Status === 'Completed') bg-green-100 text-green-800
                            @elseif($task->Status === 'In Progress') bg-blue-100 text-blue-800
                            @elseif($task->Status === 'Pending') bg-yellow-100 text-yellow-800
                            @elseif($task->Status === 'On Hold') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $task->Status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($task->Priority === 'Urgent') bg-red-100 text-red-800
                            @elseif($task->Priority === 'High') bg-orange-100 text-orange-800
                            @elseif($task->Priority === 'Medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ $task->Priority }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $task->DueDate ? \Carbon\Carbon::parse($task->DueDate)->format('d/m/Y') : 'Non définie' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $task->CompletionPercentage }}%"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $task->CompletionPercentage }}%</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('tasks.show', $task->TaskID) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('tasks.status', $task->TaskID) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="Status" value="{{ $task->Status === 'In Progress' ? 'Completed' : 'In Progress' }}">
                                <input type="hidden" name="CompletionPercentage" value="{{ $task->Status === 'In Progress' ? '100' : '0' }}">
                                <button type="submit" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
</div>
@endsection 