@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-white">{{ $portfolio->Title }}</h1>
                    <div class="space-x-2">
                        <a href="{{ route('portfolios.edit', $portfolio->PortfolioID) }}" 
                            class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Modifier
                        </a>
                        <form action="{{ route('portfolios.destroy', $portfolio->PortfolioID) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce portfolio ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contenu -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Image -->
                    @if($portfolio->ImageURL)
                        <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $portfolio->ImageURL) }}" 
                                alt="{{ $portfolio->Title }}" 
                                class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Description -->
                    <div class="prose max-w-none">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                        <p class="text-gray-600">{{ $portfolio->Description }}</p>
                    </div>

                    <!-- Informations -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Catégorie -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Catégorie</h3>
                            <span class="px-2 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $portfolio->Category }}
                            </span>
                        </div>

                        <!-- Tags -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $portfolio->Tags) as $tag)
                                    <span class="px-2 py-1 text-sm rounded-full bg-gray-200 text-gray-800">
                                        {{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Lien en direct -->
                        @if($portfolio->LiveLink)
                            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Lien en direct</h3>
                                <a href="{{ $portfolio->LiveLink }}" 
                                    target="_blank" 
                                    class="text-blue-600 hover:text-blue-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    {{ $portfolio->LiveLink }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection