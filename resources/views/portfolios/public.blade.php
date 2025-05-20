@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- En-tête avec animation -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-16 relative overflow-hidden">
        <!-- Éléments décoratifs -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        <div class="container mx-auto px-4 relative">
            <h1 class="text-4xl md:text-5xl font-bold text-white text-center mb-4 animate-fade-in">Nos Portfolios</h1>
            <p class="text-blue-100 text-center text-lg mb-8 animate-fade-in animation-delay-200">Découvrez nos réalisations et projets</p>
            
            <!-- Statistiques -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mb-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 text-center transform hover:scale-105 transition duration-300">
                    <div class="text-3xl font-bold text-white mb-1">{{ $portfolios->total() }}</div>
                    <div class="text-blue-100 text-sm">Projets</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 text-center transform hover:scale-105 transition duration-300">
                    <div class="text-3xl font-bold text-white mb-1">4</div>
                    <div class="text-blue-100 text-sm">Catégories</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 text-center transform hover:scale-105 transition duration-300">
                    <div class="text-3xl font-bold text-white mb-1">100%</div>
                    <div class="text-blue-100 text-sm">Satisfaction</div>
                </div>
                <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 text-center transform hover:scale-105 transition duration-300">
                    <div class="text-3xl font-bold text-white mb-1">24/7</div>
                    <div class="text-blue-100 text-sm">Support</div>
                </div>
            </div>
            
            <!-- Barre de recherche et filtres -->
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 transform hover:scale-[1.02] transition duration-300">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Filtre par catégorie -->
                    <div>
                        <form action="{{ route('portfolios.public') }}" method="GET">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filtrer par catégorie</label>
                            <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" onchange="this.form.submit()">
                                <option value="">Toutes les catégories</option>
                                <option value="Web Development" {{ request('category') == 'Web Development' ? 'selected' : '' }}>Développement Web</option>
                                <option value="Mobile App" {{ request('category') == 'Mobile App' ? 'selected' : '' }}>Application Mobile</option>
                                <option value="Design" {{ request('category') == 'Design' ? 'selected' : '' }}>Design</option>
                                <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </form>
                    </div>

                    <!-- Recherche -->
                    <div>
                        <form action="{{ route('portfolios.public') }}" method="GET">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <div class="flex">
                                <input type="text" name="search" id="search" 
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                    placeholder="Entrez un titre ou une description..." 
                                    value="{{ request('search') }}">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition duration-200 flex items-center">
                                    <i class="fas fa-search mr-2"></i>
                                    Rechercher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des portfolios -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($portfolios as $portfolio)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-2 hover:shadow-xl group">
                    <!-- Image avec overlay -->
                    @if ($portfolio->ImageURL)
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $portfolio->ImageURL) }}" 
                                alt="{{ $portfolio->Title }}" 
                                class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                        </div>
                    @endif

                    <!-- Contenu -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition duration-200">{{ $portfolio->Title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($portfolio->Description, 100) }}</p>
                        
                        <!-- Catégorie -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 group-hover:bg-blue-200 transition duration-200">
                                <i class="fas fa-folder-open mr-2"></i>
                                {{ $portfolio->Category }}
                            </span>
                        </div>

                        <!-- Tags -->
                        @if ($portfolio->Tags)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach (json_decode($portfolio->Tags, true) as $tag)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm group-hover:bg-gray-200 transition duration-200">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Bouton et date -->
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                            @if ($portfolio->LiveLink)
                                <a href="{{ $portfolio->LiveLink }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 group-hover:scale-105"
                                   target="_blank">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Voir en direct
                                </a>
                            @endif
                            <span class="text-sm text-gray-500 group-hover:text-gray-700 transition duration-200">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $portfolio->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $portfolios->links() }}
        </div>
    </div>
</div>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    .animate-fade-in {
        animation: fadeIn 1s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection