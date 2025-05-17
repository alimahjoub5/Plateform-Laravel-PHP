@extends('layouts.guest')

@section('content')
<div class="container py-8">
    <!-- En-tête de la section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Ce que nos clients disent de nous</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Découvrez les expériences de nos clients satisfaits et comment nous avons transformé leurs projets en succès.</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl font-bold text-primary mb-2">{{ $testimonials->total() }}</div>
            <div class="text-gray-600">Témoignages publiés</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl font-bold text-primary mb-2">
                {{ number_format($testimonials->avg('Rating'), 1) }}
            </div>
            <div class="text-gray-600">Note moyenne</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl font-bold text-primary mb-2">100%</div>
            <div class="text-gray-600">Clients satisfaits</div>
        </div>
    </div>

    <!-- Grille des témoignages -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($testimonials as $testimonial)
        <div class="bg-white rounded-lg shadow-md p-6 transition-transform hover:scale-105">
            <!-- Avatar et informations du client -->
            <div class="flex items-center mb-4">
                <img src="{{ $testimonial->user->ProfilePicture ?? 'https://ui-avatars.com/api/?name='.urlencode($testimonial->user->FirstName.' '.$testimonial->user->LastName) }}" 
                     alt="{{ $testimonial->user->FirstName.' '.$testimonial->user->LastName }}" 
                     class="w-16 h-16 rounded-full object-cover border-2 border-primary">
                <div class="ml-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $testimonial->user->FirstName.' '.$testimonial->user->LastName }}</h3>
                    <p class="text-gray-600">{{ $testimonial->project->Title }}</p>
                    <p class="text-sm text-gray-500">{{ $testimonial->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Note en étoiles -->
            <div class="mb-4">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $testimonial->Rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                @endfor
                <span class="ml-2 text-sm text-gray-600">{{ $testimonial->Rating }}/5</span>
            </div>

            <!-- Message -->
            <div class="relative">
                <i class="fas fa-quote-left text-4xl text-gray-200 absolute -top-2 -left-2"></i>
                <p class="text-gray-700 italic relative z-10 pl-6">{{ $testimonial->Content }}</p>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="text-gray-500 text-lg">
                <i class="fas fa-comments text-4xl mb-4"></i>
                <p>Aucun témoignage n'a encore été publié.</p>
                <p class="mt-2">Soyez le premier à partager votre expérience !</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($testimonials->hasPages())
    <div class="mt-8">
        {{ $testimonials->links() }}
    </div>
    @endif

    <!-- Section pour les visiteurs non connectés -->
    @guest
    <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8 shadow-sm">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Partagez votre expérience avec nous</h2>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Votre témoignage est précieux ! En partageant votre expérience, vous aidez d'autres personnes à découvrir nos services et à prendre confiance en notre expertise.
            </p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
                    <i class="fas fa-user-plus mr-2"></i> Créer un compte
                </a>
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                </a>
            </div>
        </div>
    </div>
    @endguest

    <!-- Formulaire d'ajout de témoignage pour les clients connectés -->
    @auth
        @if(auth()->user()->isClient() && $projects && $projects->count() > 0)
        <div class="mt-16 bg-white rounded-lg p-8 shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Partagez votre expérience</h2>
            
            <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700">Sélectionnez votre projet</label>
                    <select name="project_id" id="project_id" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        <option value="">Choisissez un projet...</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->ProjectID }}">{{ $project->Title }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Choisissez le projet pour lequel vous souhaitez laisser un témoignage</p>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Votre témoignage</label>
                    <textarea name="content" id="content" rows="4" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                              placeholder="Partagez votre expérience avec nous..."></textarea>
                    <p class="mt-1 text-sm text-gray-500">Minimum 10 caractères. Soyez le plus détaillé possible !</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Votre note</label>
                    <div class="flex space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="rating-star" data-rating="{{ $i }}">
                            <i class="fas fa-star text-2xl text-gray-300 hover:text-yellow-400"></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" required>
                    <p class="mt-1 text-sm text-gray-500">Cliquez sur les étoiles pour donner votre note</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-6 py-3 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i> Envoyer mon témoignage
                    </button>
                </div>
            </form>
        </div>
        @endif
    @endauth
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.rating-star').click(function() {
        const rating = $(this).data('rating');
        $('#rating').val(rating);
        
        // Mise à jour visuelle des étoiles
        $('.rating-star i').removeClass('text-yellow-400').addClass('text-gray-300');
        $('.rating-star').each(function(index) {
            if (index < rating) {
                $(this).find('i').removeClass('text-gray-300').addClass('text-yellow-400');
            }
        });
    });
});
</script>
@endpush
@endsection 