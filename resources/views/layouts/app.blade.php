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
    <!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/fr.min.js"></script> <!-- Pour la localisation en français -->
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
    <nav class="bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('users.index') }}" class="text-white text-2xl font-bold flex items-center hover:text-purple-100 transition-colors duration-200">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-10 mr-3">
                        Mon Application
                    </a>
                </div>
    
                <!-- Liens de navigation (Notifications, Profil, Déconnexion) -->
                <div class="hidden md:flex items-center space-x-2">
                    <!-- Notifications (accessible uniquement aux utilisateurs connectés) -->
                    @auth
                        <div class="relative">
                            <a href="{{ route('notifications.index') }}" class="text-white hover:bg-purple-700 px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-bell text-lg"></i>
                                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 ml-2 font-bold animate-pulse">{{ $unreadNotificationsCount }}</span>
                                @endif
                            </a>
                        </div>
                    @endauth
    
                    <!-- Menu déroulant pour l'utilisateur connecté -->
                    @auth
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center text-white hover:bg-purple-700 px-4 py-2 rounded-lg text-sm font-medium focus:outline-none transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-user-circle text-lg mr-2"></i>
                                <span>{{ Auth::user()->Username }}</span>
                                <i id="user-menu-chevron" class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200"></i>
                            </button>
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 ring-1 ring-black ring-opacity-5 z-50">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150 flex items-center">
                                    <i class="fas fa-user mr-2 text-purple-600"></i> Profil
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150 flex items-center">
                                        <i class="fas fa-sign-out-alt mr-2 text-red-500"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Liens de connexion et d'inscription (accessibles aux utilisateurs non connectés) -->
                        <a href="{{ route('login') }}" class="text-white hover:bg-purple-700 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-purple-600 hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md">
                            Inscription
                        </a>
                    @endauth
                </div>
    
                <!-- Menu mobile (hamburger) -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white focus:outline-none p-2 rounded-lg hover:bg-purple-700 transition-colors duration-200">
                        <svg id="mobile-menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="mobile-menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Menu mobile (déroulant) -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-purple-500 bg-purple-600">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Liens accessibles uniquement aux utilisateurs connectés -->
                @auth
                    <a href="{{ route('notifications.index') }}" class="text-white block hover:bg-purple-700 px-3 py-3 rounded-lg text-base font-medium flex items-center transition-colors duration-150">
                        <i class="fas fa-bell mr-3"></i> Notifications
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-auto font-bold">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('profile') }}" class="text-white block hover:bg-purple-700 px-3 py-3 rounded-lg text-base font-medium flex items-center transition-colors duration-150">
                        <i class="fas fa-user mr-3"></i> Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="text-white hover:bg-purple-700 px-3 py-3 rounded-lg text-base font-medium w-full text-left flex items-center transition-colors duration-150">
                            <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
                        </button>
                    </form>
                @else
                    <!-- Liens de connexion et d'inscription (accessibles aux utilisateurs non connectés) -->
                    <a href="{{ route('login') }}" class="text-white block hover:bg-purple-700 px-3 py-3 rounded-lg text-base font-medium transition-colors duration-150">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-purple-700 text-white block hover:bg-purple-800 px-3 py-3 rounded-lg text-base font-medium transition-colors duration-150">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenu principal avec sidebar -->
    <div class="flex">
        <!-- Sidebar dynamique -->
        @auth
        <aside class="bg-purple-600 text-white w-64 min-h-screen p-6 shadow-lg">
            <h3 class="text-xl font-bold mb-6 flex items-center text-white">
                <i class="fas fa-th-large mr-2"></i> Menu Principal
            </h3>
            <ul class="space-y-4">
                {{-- ADMIN --}}
                @if(strtolower(Auth::user()->Role) === 'admin')
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Tableau de bord</h4>
                        <a href="{{ route('admin.dashboard') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Dashboard Admin</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Gestion des utilisateurs</h4>
                        <a href="{{ route('users.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Liste des utilisateurs</a>
                        <a href="{{ route('users.create') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Créer un utilisateur</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Gestion des projets</h4>
                        <a href="{{ route('admin.projects') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Liste des projets</a>
                        <a href="{{ route('projects.create') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Créer un projet</a>
                        <a href="{{ route('tasks.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Liste des tâches</a>
                        <a href="{{ route('tasks.create') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Créer une tâche</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Factures & Devis</h4>
                        <a href="{{ route('invoices.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Factures</a>
                        <a href="{{ route('projects.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Créer une facture</a>
                        <a href="{{ route('devis.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Devis</a>
                        <a href="{{ route('devis.create') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Créer un devis</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Ressources</h4>
                        <a href="{{ route('portfolios.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Portfolios</a>
                        <a href="{{ route('testimonials.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Témoignages</a>
                        <a href="{{ route('services.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Services</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Communication</h4>
                        <a href="{{ route('chat.list') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Messages</a>
                        <a href="{{ route('meetings.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Réunions</a>
                        <a href="{{ route('meetings.calendar') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Planning</a>
                        <a href="{{ route('notifications.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Notifications</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Rapports & Statistiques</h4>
                        <a href="{{ route('admin.dashboard') }}#stats" class="block p-2 text-white hover:bg-purple-700 rounded">Statistiques générales</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Paramètres</h4>
                        <a href="{{ route('profile') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mon profil</a>
                    </li>
                @endif
                {{-- CLIENT --}}
                @if(strtolower(Auth::user()->Role) === 'client')
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Tableau de bord</h4>
                        <a href="{{ route('client.dashboard') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Dashboard Client</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Projets & Devis</h4>
                        <a href="{{ route('projects.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mes projets</a>
                        <a href="{{ route('client.devis.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mes devis</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Factures & Paiements</h4>
                        <a href="{{ route('invoices.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mes factures</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Notifications</h4>
                        <a href="{{ route('notifications.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Notifications</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Communication</h4>
                        <a href="{{ route('chat.list') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Messages</a>
                        <a href="{{ route('meetings.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Réunions</a>
                        <a href="{{ route('meetings.calendar') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Planning</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Profil</h4>
                        <a href="{{ route('profile') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mon profil</a>
                    </li>
                @endif
                {{-- FREELANCER --}}
                @if(strtolower(Auth::user()->Role) === 'freelancer')
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Tableau de bord</h4>
                        <a href="{{ route('freelancer.dashboard') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Dashboard Freelancer</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Projets & Tâches</h4>
                        <a href="{{ route('freelancer.projects') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mes projets</a>
                        <a href="{{ route('freelancer.tasks') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mes tâches</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Communication</h4>
                        <a href="{{ route('chat.list') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Messages</a>
                        <a href="{{ route('meetings.index') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Réunions</a>
                        <a href="{{ route('meetings.calendar') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Planning</a>
                    </li>
                    <li class="mb-4">
                        <h4 class="text-sm font-semibold text-white uppercase mb-2">Profil</h4>
                        <a href="{{ route('profile') }}" class="block p-2 text-white hover:bg-purple-700 rounded">Mon profil</a>
                    </li>
                @endif
            </ul>
        </aside>
        @endauth

        <!-- Contenu principal -->
        <main class="flex-1 p-6">
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
    <footer class="bg-purple-600 text-white mt-8">
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
            <div class="border-t border-purple-500 mt-6 pt-6 text-center">
                <p class="text-sm">
                    &copy; {{ date('Y') }} Mon Application. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gestion du menu mobile
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuIconOpen = document.getElementById('mobile-menu-icon-open');
        const mobileMenuIconClose = document.getElementById('mobile-menu-icon-close');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                if (mobileMenuIconOpen && mobileMenuIconClose) {
                    mobileMenuIconOpen.classList.toggle('hidden');
                    mobileMenuIconClose.classList.toggle('hidden');
                }
            });
        }

        // Gestion du menu utilisateur
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const userMenuChevron = document.getElementById('user-menu-chevron');

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
                if (userMenuChevron) {
                    userMenuChevron.classList.toggle('rotate-180');
                }
            });
        }

        // Fermer les menus lorsqu'on clique à l'extérieur
        document.addEventListener('click', function(event) {
            // Fermer le menu mobile
            if (mobileMenu && mobileMenuButton) {
                const isClickInsideMobileMenu = mobileMenu.contains(event.target);
                const isClickOnMobileButton = event.target.closest('#mobile-menu-button');

                if (!isClickInsideMobileMenu && !isClickOnMobileButton && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    if (mobileMenuIconOpen && mobileMenuIconClose) {
                        mobileMenuIconOpen.classList.remove('hidden');
                        mobileMenuIconClose.classList.add('hidden');
                    }
                }
            }

            // Fermer le menu utilisateur
            if (userMenu && userMenuButton) {
                const isClickInsideUserMenu = userMenu.contains(event.target);
                const isClickOnUserButton = event.target.closest('#user-menu-button');

                if (!isClickInsideUserMenu && !isClickOnUserButton && !userMenu.classList.contains('hidden')) {
                    userMenu.classList.add('hidden');
                    if (userMenuChevron) {
                        userMenuChevron.classList.remove('rotate-180');
                    }
                }
            }
        });

        // Fermer le menu mobile lorsqu'on clique sur un lien
        if (mobileMenu) {
            const mobileMenuLinks = mobileMenu.querySelectorAll('a, button');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    if (mobileMenuIconOpen && mobileMenuIconClose) {
                        mobileMenuIconOpen.classList.remove('hidden');
                        mobileMenuIconClose.classList.add('hidden');
                    }
                });
            });
        }
    </script>
    
</body>
</html>
