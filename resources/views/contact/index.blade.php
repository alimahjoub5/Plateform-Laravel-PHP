@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8 relative">
    <!-- Fond animé -->
    <div id="particles-js" class="absolute inset-0 z-0"></div>

    <div class="max-w-4xl w-full bg-white rounded-xl shadow-2xl overflow-hidden relative z-10">
        <!-- En-tête avec illustration -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Contactez-nous</h1>
            <p class="text-lg text-blue-100">Nous sommes là pour répondre à vos questions.</p>
        </div>

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <!-- Formulaire de contact -->
            <div>
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    <!-- Nom -->
                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Nom</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Votre nom" required>
                    </div>

                    <!-- E-mail -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">E-mail</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Votre e-mail" required>
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
                        <textarea name="message" id="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Votre message" required></textarea>
                    </div>

                    <!-- Bouton d'envoi -->
                    <div class="text-center">
                        <button type="submit" id="submit-btn" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition duration-300 transform hover:scale-105">
                            <span id="submit-text">Envoyer <i class="fas fa-paper-plane ml-2"></i></span>
                            <span id="submit-spinner" class="hidden">
                                <i class="fas fa-spinner fa-spin"></i> Envoi en cours...
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Message de succès -->
                @if (session('success'))
                    <div class="mt-4 text-center text-green-600 font-semibold">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif
            </div>

            <!-- Informations de contact et réseaux sociaux -->
            <div class="bg-gray-50 p-8 rounded-lg">
                <h2 class="text-2xl font-bold mb-6">Informations de contact</h2>
                <div class="space-y-4">
                    <p class="text-gray-700">
                        <i class="fas fa-phone-alt mr-2"></i> {{ $contactInfo->phone ?? '+33 1 23 45 67 89' }}
                    </p>
                    <p class="text-gray-700">
                        <i class="fas fa-envelope mr-2"></i> {{ $contactInfo->email ?? 'contact@example.com' }}
                    </p>
                    <p class="text-gray-700">
                        <i class="fas fa-map-marker-alt mr-2"></i> {{ $contactInfo->address ?? '123 Rue de l\'Exemple, 75001 Paris' }}
                    </p>
                    <p class="text-gray-700">
                        <i class="fas fa-clock mr-2"></i> {{ $contactInfo->working_hours ?? 'Lundi - Vendredi : 9h - 18h' }}
                    </p>
                </div>
            
<!-- Réseaux sociaux -->
<div class="mt-8">
    <h2 class="text-2xl font-bold mb-6">Suivez-nous</h2>
    <div class="flex justify-center space-x-4">
        @if($contactInfo->facebook_url)
            <a href="{{ $contactInfo->facebook_url }}" class="text-blue-600 hover:text-blue-800 transition duration-300">
                <i class="fab fa-facebook-square text-3xl"></i>
            </a>
        @endif

        @if($contactInfo->twitter_url)
            <a href="{{ $contactInfo->twitter_url }}" class="text-blue-400 hover:text-blue-600 transition duration-300">
                <i class="fab fa-twitter-square text-3xl"></i>
            </a>
        @endif

        @if($contactInfo->linkedin_url)
            <a href="{{ $contactInfo->linkedin_url }}" class="text-blue-700 hover:text-blue-900 transition duration-300">
                <i class="fab fa-linkedin text-3xl"></i>
            </a>
        @endif

        @if($contactInfo->instagram_url)
            <a href="{{ $contactInfo->instagram_url }}" class="text-pink-500 hover:text-pink-700 transition duration-300">
                <i class="fab fa-instagram-square text-3xl"></i>
            </a>
        @endif
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<!-- Script pour le fond animé -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    particlesJS.load('particles-js', 'particles.json', function() {
        console.log('Particles.js config loaded');
    });
</script>

<!-- Script pour le spinner -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitSpinner = document.getElementById('submit-spinner');

        form.addEventListener('submit', function () {
            submitText.classList.add('hidden');
            submitSpinner.classList.remove('hidden');
            submitBtn.disabled = true;
        });
    });
</script>
@endsection