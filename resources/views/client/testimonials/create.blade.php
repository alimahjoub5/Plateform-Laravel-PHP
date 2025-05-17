@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Ajouter un Témoignage</h1>
            <p class="text-lg text-gray-600">Partagez votre expérience sur un projet terminé</p>
        </div>

        <!-- Messages d'erreur -->
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 animate-fade-in" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <div>
                        <p class="font-bold">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('client.testimonials.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Sélection du projet -->
                <div>
                    <label for="project_id" class="block text-lg font-medium text-gray-700 mb-2">
                        <i class="fas fa-project-diagram mr-2"></i>
                        Projet
                    </label>
                    <select name="project_id" id="project_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg">
                        <option value="">Sélectionnez un projet</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->ProjectID }}" {{ old('project_id') == $project->ProjectID ? 'selected' : '' }}>
                                {{ $project->Title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Note -->
                <div>
                    <label class="block text-lg font-medium text-gray-700 mb-2">
                        <i class="fas fa-star mr-2"></i>
                        Note
                    </label>
                    <div class="flex items-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="hidden" {{ old('rating') == $i ? 'checked' : '' }}>
                            <label for="rating{{ $i }}" class="cursor-pointer transform hover:scale-110 transition-transform duration-200">
                                <svg class="w-10 h-10 text-gray-300 hover:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Contenu du témoignage -->
                <div>
                    <label for="content" class="block text-lg font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment-alt mr-2"></i>
                        Votre témoignage
                    </label>
                    <textarea name="content" id="content" rows="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg" placeholder="Partagez votre expérience...">{{ old('content') }}</textarea>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('client.testimonials.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Soumettre
                    </button>
                </div>
            </form>
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

@push('scripts')
<script>
    // Script pour gérer l'affichage des étoiles de notation
    document.querySelectorAll('input[name="rating"]').forEach((input, index) => {
        input.addEventListener('change', () => {
            document.querySelectorAll('input[name="rating"]').forEach((star, i) => {
                const label = star.nextElementSibling;
                if (i <= index) {
                    label.querySelector('svg').classList.remove('text-gray-300');
                    label.querySelector('svg').classList.add('text-yellow-400');
                } else {
                    label.querySelector('svg').classList.remove('text-yellow-400');
                    label.querySelector('svg').classList.add('text-gray-300');
                }
            });
        });
    });
</script>
@endpush
@endsection 