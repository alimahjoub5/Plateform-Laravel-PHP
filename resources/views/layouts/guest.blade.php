<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Mon Application')</title>
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
                    <a href="{{ route('portfolios.public') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Portfolios</a>
    
                    <!-- Liens conditionnels -->
                    @auth
                        <!-- Lien "Application" pour les utilisateurs authentifiés -->
                        <a href="{{ route('users.index') }}" class="bg-white text-blue-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">Application</a>
                        <!-- Lien "Mes Témoignages" pour les utilisateurs authentifiés -->
                        <a href="{{ route('client.testimonials.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-star mr-1"></i>Mes Témoignages
                        </a>
                    @else
                        <!-- Liens pour les utilisateurs non authentifiés -->
                        <a href="{{ route('login') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Inscription</a>
                        <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">Contact</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mx-auto p-4 pt-20">
        @yield('content')
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