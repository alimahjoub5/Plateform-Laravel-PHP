<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Mon Application</title>
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
                    <a href="{{ route('users.index') }}" class="text-white text-2xl font-bold">Mon Application</a>
                </div>

                <!-- Liens de navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#features" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Fonctionnalités</a>
                    <a href="#about" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">À propos</a>
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

    <!-- Testimonials Section -->
    <div id="testimonials" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Témoignages</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Témoignage 1 -->
                <div class="text-center animate__animated animate__fadeInUp">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <i class="fas fa-quote-left text-2xl text-blue-600 mb-4"></i>
                        <p class="text-gray-700 mb-4">
                            "Mon Application a révolutionné notre façon de travailler. Tout est plus simple et plus efficace."
                        </p>
                        <p class="text-gray-600 font-semibold">— Jean Dupont, Développeur</p>
                    </div>
                </div>

                <!-- Témoignage 2 -->
                <div class="text-center animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <i class="fas fa-quote-left text-2xl text-blue-600 mb-4"></i>
                        <p class="text-gray-700 mb-4">
                            "La gestion des tâches est incroyablement intuitive. Je recommande vivement cette plateforme."
                        </p>
                        <p class="text-gray-600 font-semibold">— Marie Martin, Chef de projet</p>
                    </div>
                </div>

                <!-- Témoignage 3 -->
                <div class="text-center animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <i class="fas fa-quote-left text-2xl text-blue-600 mb-4"></i>
                        <p class="text-gray-700 mb-4">
                            "Une excellente solution pour les équipes. La collaboration n'a jamais été aussi facile."
                        </p>
                        <p class="text-gray-600 font-semibold">— Pierre Leroy, Client</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <li><a href="#features" class="text-sm hover:underline">Fonctionnalités</a></li>
                        <li><a href="#about" class="text-sm hover:underline">À propos</a></li>
                        <li><a href="#testimonials" class="text-sm hover:underline">Témoignages</a></li>
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