@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête avec animation -->
        <div class="text-center mb-12 transform hover:scale-105 transition-transform duration-300">
            <h1 class="text-4xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Mes Témoignages</h1>
            <p class="text-lg text-gray-600">Partagez votre expérience avec nos services</p>
        </div>

        <!-- Messages de succès/erreur avec animation -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 animate-fade-in" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 animate-fade-in" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Bouton d'ajout de témoignage -->
        @if($projects->count() > 0)
            <div class="text-center mb-8">
                <a href="{{ route('client.testimonials.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Ajouter un nouveau témoignage
                </a>
            </div>
        @endif

        <!-- Liste des témoignages -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-4">Mes témoignages</h2>
            
            @if($testimonials->count() > 0)
                <div class="space-y-6">
                    @foreach($testimonials as $testimonial)
                        <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $testimonial->project->Title }}</h3>
                                    <div class="flex items-center space-x-4 mb-3">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-6 h-6 {{ $i <= $testimonial->Rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $testimonial->created_at ? $testimonial->created_at->format('d/m/Y') : 'N/A' }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mb-4">{{ $testimonial->Content }}</p>
                                </div>
                                <div class="ml-4">
                                    <span class="px-4 py-2 rounded-full text-sm font-medium
                                        @if($testimonial->Status === 'Approved') bg-green-100 text-green-800
                                        @elseif($testimonial->Status === 'Rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        {{ $testimonial->Status }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($testimonial->Status !== 'Approved')
                                <div class="mt-4 flex justify-end space-x-3">
                                    <a href="{{ route('client.testimonials.edit', $testimonial) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <i class="fas fa-edit mr-2"></i>
                                        Modifier
                                    </a>
                                    <form action="{{ route('client.testimonials.destroy', $testimonial) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')">
                                            <i class="fas fa-trash-alt mr-2"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-comments text-6xl"></i>
                    </div>
                    <p class="text-gray-500 text-lg">Vous n'avez pas encore soumis de témoignages.</p>
                    @if($projects->count() > 0)
                        <a href="{{ route('client.testimonials.create') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus-circle mr-1"></i>
                            Ajouter votre premier témoignage
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection 