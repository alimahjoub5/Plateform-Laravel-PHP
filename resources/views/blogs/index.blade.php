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
                    <a href="{{ route('blogs.index') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Blogs</a>
                    <a href="{{ route('testimonials') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Témoignages</a>
                    <a href="{{ route('login') }}" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">Inscription</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container pt-16"> <!-- Ajout de pt-16 pour compenser la navbar fixe -->
        <h1 class="text-center my-4">Liste des blogs</h1>

        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Image de couverture -->
                        @if ($blog->FeaturedImage)
                        <img src="{{ asset('storage/' . $blog->FeaturedImage) }}" alt="Image mise en avant" class="blog-image img-fluid">                        @else
                            <div class="text-center py-5 bg-light">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="mt-2 text-muted">Aucune image</p>
                            </div>
                        @endif

                        <div class="card-body">
                            <!-- Catégorie -->
                            <span class="badge bg-primary mb-2">{{ $blog->Category }}</span>

                            <!-- Titre -->
                            <h5 class="card-title">{{ $blog->Title }}</h5>

                            <!-- Contenu tronqué -->
                            <p class="card-text">{{ Str::limit(strip_tags($blog->Content), 100) }}</p>

                            <!-- Auteur et date -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> {{ $blog->author->Username ?? 'Auteur inconnu' }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt"></i> {{ $blog->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>

                        <!-- Bouton "Lire la suite" -->
                        <div class="card-footer bg-white">
                            <a href="{{ route('blogs.show', $blog->BlogID) }}" class="btn btn-outline-primary w-100">
                                Lire la suite <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $blogs->links() }}
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-footer {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
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