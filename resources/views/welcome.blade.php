<!-- resources/views/auth/register.blade.php -->
@extends('layouts.guest')

@section('content')

    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-32">
        <div class="max-w-4xl mx-auto text-center animate__animated animate__fadeIn">
            <h1 class="text-5xl font-bold mb-6">Bienvenue sur Mon Application</h1>
            <p class="text-xl mb-8">
                Une plateforme intuitive pour gérer vos projets, collaborateurs et tâches en toute simplicité.
            </p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">Commencer</a>
                <a href="#features" class="bg-transparent border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600">En savoir plus</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Fonctionnalités</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center animate__animated animate__fadeInUp">
                    <i class="fas fa-tasks text-5xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Gestion des tâches</h3>
                    <p class="text-gray-600">
                        Organisez et suivez vos tâches efficacement avec des outils puissants.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center animate__animated animate__fadeInUp animate__delay-1s">
                    <i class="fas fa-users text-5xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Collaboration</h3>
                    <p class="text-gray-600">
                        Travaillez en équipe et partagez des ressources en temps réel.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center animate__animated animate__fadeInUp animate__delay-2s">
                    <i class="fas fa-chart-line text-5xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Analytiques</h3>
                    <p class="text-gray-600">
                        Obtenez des insights sur vos projets et performances.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">À propos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Texte -->
                <div class="animate__animated animate__fadeInLeft">
                    <p class="text-gray-700 mb-4">
                        Mon Application est une plateforme conçue pour simplifier la gestion de vos projets et améliorer la collaboration entre les membres de votre équipe.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Que vous soyez un développeur, un client ou un administrateur, notre outil vous offre les fonctionnalités nécessaires pour rester organisé et productif.
                    </p>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">Rejoignez-nous</a>
                </div>

                <!-- Image -->
                <div class="flex justify-center animate__animated animate__fadeInRight">
                    <img src="https://via.placeholder.com/400" alt="À propos" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>


    <!-- Services Section -->
<div id="services" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Nos Services</h2>

        <!-- Filtres par catégorie -->
        <div class="flex justify-center gap-4 mb-8">
            <button class="filter-btn px-4 py-2 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors" data-category="all">Tous</button>
            <button class="filter-btn px-4 py-2 rounded-full bg-gray-300 text-gray-700 hover:bg-gray-400 transition-colors" data-category="Development">Développement</button>
            <button class="filter-btn px-4 py-2 rounded-full bg-gray-300 text-gray-700 hover:bg-gray-400 transition-colors" data-category="Design">Design</button>
            <button class="filter-btn px-4 py-2 rounded-full bg-gray-300 text-gray-700 hover:bg-gray-400 transition-colors" data-category="Consulting">Consulting</button>
            <button class="filter-btn px-4 py-2 rounded-full bg-gray-300 text-gray-700 hover:bg-gray-400 transition-colors" data-category="Other">Autre</button>
        </div>


        <!-- Liste des services -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($services as $service)
                <div class="service-card text-center bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105 hover:shadow-lg animate__animated animate__fadeInUp" data-category="{{ $service->Category }}">
                    <!-- Icône du service -->
                    <div class="w-full h-48 flex items-center justify-center bg-blue-50">
                        @if ($service->Category === 'Development')
                            <i class="fas fa-code text-6xl text-blue-500"></i> <!-- Icône pour Développement -->
                        @elseif ($service->Category === 'Design')
                            <i class="fas fa-paint-brush text-6xl text-purple-500"></i> <!-- Icône pour Design -->
                        @elseif ($service->Category === 'Consulting')
                            <i class="fas fa-chart-line text-6xl text-green-500"></i> <!-- Icône pour Consulting -->
                        @else
                            <i class="fas fa-cogs text-6xl text-gray-500"></i> <!-- Icône par défaut -->
                        @endif
                    </div>

                    <!-- Contenu du service -->
                    <div class="p-6">
                        <!-- Nom du service -->
                        <h3 class="text-xl font-semibold mb-2">{{ $service->ServiceName }}</h3>

                        <!-- Catégorie -->
                        <p class="text-gray-600 mb-4">
                            <span class="inline-block bg-blue-500 text-white text-sm px-2 py-1 rounded-full">
                                {{ $service->Category }}
                            </span>
                        </p>

                        <!-- Description -->
                        <p class="text-gray-700 mb-4">{{ Str::limit($service->Description, 100) }}</p>

                        <!-- Prix -->
                        <p class="text-gray-800 font-bold mb-4">
                            {{ number_format($service->Price, 2) }} €
                        </p>

                        <!-- Disponibilité -->
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-check-circle"></i>
                            {{ $service->IsAvailable ? 'Disponible' : 'Non disponible' }}
                        </p>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Script pour le filtrage des services -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const serviceCards = document.querySelectorAll('.service-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const category = button.getAttribute('data-category');

                // Retirer la classe active de tous les boutons
                filterButtons.forEach(btn => btn.classList.remove('bg-blue-500', 'text-white', 'hover:bg-blue-600'));
                filterButtons.forEach(btn => btn.classList.add('bg-gray-300', 'text-gray-700', 'hover:bg-gray-400'));

                // Ajouter la classe active au bouton cliqué
                button.classList.remove('bg-gray-300', 'text-gray-700', 'hover:bg-gray-400');
                button.classList.add('bg-blue-500', 'text-white', 'hover:bg-blue-600');

                // Filtrer les services
                serviceCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>


    <!-- Team Section -->
<div id="team" class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Notre Équipe</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($teamMembers as $member)
                <div class="text-center animate__animated animate__fadeInUp">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <!-- Photo de profil -->
                        @if ($member->ProfilePicture)
                            <img src="{{ asset('storage/' . $member->ProfilePicture) }}" alt="{{ $member->Username }}" class="w-24 h-24 rounded-full mx-auto mb-4">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-3xl text-gray-400"></i>
                            </div>
                        @endif

                        <!-- Nom et rôle -->
                        <h3 class="text-xl font-semibold mb-2">{{ $member->Username }}</h3>
                        <p class="text-gray-600 mb-4">{{ $member->Role }}</p>

                        <!-- Bio -->
                        @if ($member->Bio)
                            <p class="text-gray-700 mb-4">{{ Str::limit($member->Bio, 100) }}</p>
                        @else
                            <p class="text-gray-500">Aucune bio disponible.</p>
                        @endif

                        <!-- Langue -->
                        @if ($member->Language)
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-globe"></i> {{ $member->Language }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

    @endsection