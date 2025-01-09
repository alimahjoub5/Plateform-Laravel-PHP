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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        // Initialiser CKEditor sur le textarea avec l'id "Content"
        CKEDITOR.replace('Content', {
            height: 400, // Hauteur de l'éditeur
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'Source'] } // Option pour voir le code source
            ],
            removeButtons: 'Subscript,Superscript', // Boutons à désactiver
            language: 'fr', // Langue française
        });
    </script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <!-- Logo -->
                <div class="flex items-center py-4">
                    <a href="{{ route('users.index') }}" class="text-white text-2xl font-bold">Mon Application</a>
                </div>
    
                <!-- Liens de navigation (Notifications, Profil, Déconnexion) -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Notifications (accessible uniquement aux utilisateurs connectés) -->
                    @auth
                        <div class="relative">
                            <a href="{{ route('notifications.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                                <i class="fas fa-bell"></i>
                                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1">{{ $unreadNotificationsCount }}</span>
                                @endif
                            </a>
                        </div>
                    @endauth
    
                    <!-- Menu déroulant pour l'utilisateur connecté -->
                    @auth
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium focus:outline-none">
                                <span>{{ Auth::user()->Username }}</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @csrf
                                    <button type="submit">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Liens de connexion et d'inscription (accessibles aux utilisateurs non connectés) -->
                        <a href="{{ route('login') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Inscription</a>
                    @endauth
                </div>
    
                <!-- Menu mobile (hamburger) -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Menu mobile (déroulant) -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <!-- Liens accessibles uniquement aux utilisateurs connectés -->
                @auth
                    <a href="{{ route('notifications.index') }}" class="text-white block hover:bg-blue-700 px-3 py-2 rounded-md text-base font-medium flex items-center">
                        <i class="fas fa-bell mr-2"></i> Notifications
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('profile') }}" class="text-white block hover:bg-blue-700 px-3 py-2 rounded-md text-base font-medium">Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-base font-medium w-full text-left">Déconnexion</button>
                    </form>
                @else
                    <!-- Liens de connexion et d'inscription (accessibles aux utilisateurs non connectés) -->
                    <a href="{{ route('login') }}" class="text-white block hover:bg-blue-700 px-3 py-2 rounded-md text-base font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="text-white block hover:bg-blue-700 px-3 py-2 rounded-md text-base font-medium">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenu principal avec sidebar -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="bg-blue-800 text-white w-64 min-h-screen p-6 shadow-lg">
            <!-- Titre du menu -->
            <h3 class="text-xl font-bold mb-6 flex items-center text-white">
                <i class="fas fa-bars mr-2"></i> Menu
            </h3>
        
            <!-- Liste des liens -->
            <ul class="space-y-3">
                <!-- Lien "Gérer les blogs" -->
                <li>
                    <a href="{{ route('blogs.dashboard') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white">
                        <i class="fas fa-blog mr-3"></i> Gérer les blogs
                    </a>
                </li>
        
                <!-- Lien "Liste des projets" -->
                <li>
                    <a href="{{ route('admin.projects') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white">
                        <i class="fas fa-project-diagram mr-3"></i> Liste des projets
                    </a>
                </li>

        
<!-- Lien "Liste des utilisateurs" -->
<li>
    <a href="{{ route('users.index') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white" title="Voir la liste des utilisateurs">
        <i class="fas fa-users mr-3"></i> Liste des utilisateurs
    </a>
</li>

<!-- Lien "Devis" -->
<li>
    <a href="{{ route('devis.index') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white" title="Gérer les devis">
        <i class="fas fa-file-invoice mr-3"></i> Devis
    </a>
</li>
<li>
    <a href="{{ route('client.devis.index') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white" title="Gérer les devis">
        <i class="fas fa-file-invoice mr-3"></i> devis pour client
    </a>
</li>
        
                <!-- Lien "Mes services" -->
                <li>
                    <a href="{{ route('client.services') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white">
                        <i class="fas fa-cogs mr-3"></i> Mes services
                    </a>
                </li>
        
                <!-- Lien "Gérer les services" -->
                <li>
                    <a href="{{ route('services.index') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white">
                        <i class="fas fa-tools mr-3"></i> Gérer les services
                    </a>
                </li>
        
                <!-- Lien "Informations de contact" -->
                <li>
                    <a href="{{ route('dashboard.contact-info.edit') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white">
                        <i class="fas fa-edit mr-3"></i> Informations de contact
                    </a>
                </li>
        
                <!-- Lien "Dashboard" -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-sm hover:bg-blue-700 rounded-lg transition duration-300 text-white">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 p-4">
            <!-- Notifications flash -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Contenu dynamique -->
            <div class="container mx-auto p-4">
                @yield('content')
            </div>
        </main>
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
                        <li><a href="{{ route('admin.projects') }}" class="text-sm hover:underline">Liste des projets</a></li>
                        <li><a href="{{ route('users.index') }}" class="text-sm hover:underline">Liste des utilisateurs</a></li>
                        <li><a href="#" class="text-sm hover:underline">Contact</a></li>
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

    <!-- Scripts -->
    <script>
        // Gestion du menu mobile
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Gestion du menu utilisateur
        document.getElementById('user-menu-button').addEventListener('click', function() {
            const userMenu = document.getElementById('user-menu');
            userMenu.classList.toggle('hidden');
        });

        // Fermer les menus lorsqu'on clique à l'extérieur
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const userMenu = document.getElementById('user-menu');
            const isClickInsideMobileMenu = mobileMenu.contains(event.target);
            const isClickInsideUserMenu = userMenu.contains(event.target);
            const isClickOnMobileButton = event.target.closest('#mobile-menu-button');
            const isClickOnUserButton = event.target.closest('#user-menu-button');

            if (!isClickInsideMobileMenu && !isClickOnMobileButton) {
                mobileMenu.classList.add('hidden');
            }
            if (!isClickInsideUserMenu && !isClickOnUserButton) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>