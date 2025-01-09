<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Témoignages - Mon Application</title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Animation CSS (via Tailwind) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 shadow-lg fixed w-full z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('testimonials') }}" class="text-white text-2xl font-bold">Mon Application</a>
                </div>

                <!-- Liens de navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('default') }}#features" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Fonctionnalités</a>
                    <a href="{{ route('default') }}#about" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">À propos</a>
                    <!-- Lien vers la liste des blogs (accessible à tous) -->
                    <a href="{{ route('blogs.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Blogs</a>
                    <a href="{{ route('testimonials') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Témoignages</a>
                    <a href="{{ route('login') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">Inscription</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-32">
        <div class="max-w-4xl mx-auto text-center animate__animated animate__fadeIn">
            <h1 class="text-5xl font-bold mb-6">Témoignages</h1>
            <p class="text-xl mb-8">
                Découvrez ce que nos utilisateurs disent de Mon Application.
            </p>
        </div>
    </div>

    <!-- Statistiques de satisfaction -->
<!-- Statistiques de satisfaction -->
<!-- Statistiques de satisfaction -->
<div class="container mx-auto px-4 py-16 bg-white">
    <h2 class="text-3xl font-bold text-center mb-12">Notre satisfaction client</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="text-center">
            <i class="fas fa-smile text-5xl text-blue-600 mb-4"></i>
            <h3 class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($satisfactionPercentage, 0) }}%</h3>
            <p class="text-gray-600">Clients satisfaits</p>
        </div>
        <div class="text-center">
            <i class="fas fa-users text-5xl text-blue-600 mb-4"></i>
            <h3 class="text-4xl font-bold text-blue-600 mb-2">{{ $activeClientsCount }}+</h3>
            <p class="text-gray-600">Utilisateurs actifs</p>
        </div>
        <div class="text-center">
            <i class="fas fa-tasks text-5xl text-blue-600 mb-4"></i>
            <h3 class="text-4xl font-bold text-blue-600 mb-2">98%</h3>
            <p class="text-gray-600">Tâches accomplies</p>
        </div>
        <div class="text-center">
            <i class="fas fa-star text-5xl text-blue-600 mb-4"></i>
            <h3 class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($averageRating, 1) }}/5</h3>
            <p class="text-gray-600">Note moyenne</p>
        </div>
    </div>
</div>

   <!-- Testimonials Section -->
 <!-- Testimonials Section -->
 <div class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Ce qu'ils disent de nous</h2>

        <!-- Swiper Container -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md text-center">
                        <i class="fas fa-quote-left text-2xl text-blue-600 mb-4"></i>
                        <p class="text-gray-700 mb-4">
                            "{{ $testimonial->Feedback }}"
                        </p>
                        <p class="text-gray-600 font-semibold">— {{ $testimonial->client->Username }}, {{ $testimonial->project->Title }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination mt-8"></div>
        </div>
    </div>
</div>
<script>
    // Initialiser Swiper
    const swiper = new Swiper('.swiper-container', {
        loop: true, // Permet de boucler les slides
        pagination: {
            el: '.swiper-pagination', // Ajoute la pagination
            clickable: true, // Permet de cliquer sur les points pour naviguer
        },
        autoplay: {
            delay: 5000, // Défilement automatique toutes les 5 secondes
        },
    });
</script>

<style>
    .swiper-container {
        width: 100%;
        padding: 20px 0;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-pagination {
        position: relative; /* Position relative pour rester dans le cadre */
        margin-top: 20px; /* Espacement entre les témoignages et la pagination */
    }

    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background-color: #ccc; /* Couleur des points inactifs */
        opacity: 1;
    }

    .swiper-pagination-bullet-active {
        background-color: #3B82F6; /* Couleur du point actif */
    }
</style>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white mt-8">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Section 1 : À propos -->
                <div>
                    <h3 class="text-lg font-bold mb-4">À propos</h3>
                    <p class="text-sm">
                        Mon Application est une plateforme de gestion des utilisateurs conçue pour simplifier vos tâches quotidiennes.
                    </p>
                </div>

                <!-- Section 2 : Liens utiles -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Liens utiles</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('testimonials') }}#features" class="text-sm hover:underline">Fonctionnalités</a></li>
                        <li><a href="{{ route('testimonials') }}#about" class="text-sm hover:underline">À propos</a></li>
                        <li><a href="{{ route('testimonials') }}" class="text-sm hover:underline">Témoignages</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm hover:underline">Connexion</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm hover:underline">Inscription</a></li>
                    </ul>
                </div>

                <!-- Section 3 : Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="text-sm">Email: contact@monapplication.com</li>
                        <li class="text-sm">Téléphone: +33 1 23 45 67 89</li>
                        <li class="text-sm">Adresse: 123 Rue de l'Exemple, Paris, France</li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-blue-500 mt-6 pt-6 text-center">
                <p class="text-sm">
                    &copy; {{ date('Y') }} Mon Application. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>