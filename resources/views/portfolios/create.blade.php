@extends('layouts.app')

@section('title', 'Créer un Portfolio')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- En-tête -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white">Créer un nouveau Portfolio</h1>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    <!-- Champ Projet -->
                    <div class="space-y-2">
                        <label for="ProjectID" class="block text-sm font-medium text-gray-700">Projet</label>
                        <select name="ProjectID" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('ProjectID') border-red-500 @enderror" required>
                            <option value="">Sélectionnez un projet terminé</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->ProjectID }}" {{ old('ProjectID') == $project->ProjectID ? 'selected' : '' }}>
                                    {{ $project->Title }}
                                </option>
                            @endforeach
                        </select>
                        @error('ProjectID')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Titre -->
                    <div class="space-y-2">
                        <label for="Title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="Title" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('Title') border-red-500 @enderror" 
                            value="{{ old('Title') }}" required>
                        @error('Title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Description -->
                    <div class="space-y-2">
                        <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="Description" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('Description') border-red-500 @enderror" 
                            required>{{ old('Description') }}</textarea>
                        @error('Description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Image -->
                    <div class="space-y-2">
                        <label for="ImageURL" class="block text-sm font-medium text-gray-700">Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="ImageURL" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Télécharger une image</span>
                                        <input type="file" name="ImageURL" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 10MB</p>
                            </div>
                        </div>
                        @error('ImageURL')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Lien en direct -->
                    <div class="space-y-2">
                        <label for="LiveLink" class="block text-sm font-medium text-gray-700">Lien en direct</label>
                        <input type="text" name="LiveLink" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('LiveLink') border-red-500 @enderror" 
                            value="{{ old('LiveLink') }}" placeholder="https://...">
                        @error('LiveLink')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Catégorie -->
                    <div class="space-y-2">
                        <label for="Category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="Category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('Category') border-red-500 @enderror" 
                            required>
                            <option value="Web Development" {{ old('Category') == 'Web Development' ? 'selected' : '' }}>Développement Web</option>
                            <option value="Mobile App" {{ old('Category') == 'Mobile App' ? 'selected' : '' }}>Application Mobile</option>
                            <option value="Design" {{ old('Category') == 'Design' ? 'selected' : '' }}>Design</option>
                            <option value="Other" {{ old('Category') == 'Other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('Category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Tags -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                                <label class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800 cursor-pointer hover:bg-gray-200 transition duration-200">
                                    <input type="checkbox" name="Tags[]" value="{{ $tag }}" 
                                        class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                        {{ in_array($tag, json_decode(old('Tags', '[]'), true)) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $tag }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('Tags')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Sélectionnez un ou plusieurs tags.</p>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('portfolios.index') }}" 
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Annuler
                        </a>
                        <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Créer le portfolio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Prévisualisation de l'image
    document.querySelector('input[type="file"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'mt-2 mx-auto h-32 w-auto object-cover rounded-lg';
                const container = document.querySelector('.border-dashed');
                const existingPreview = container.querySelector('img');
                if (existingPreview) {
                    existingPreview.remove();
                }
                container.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection