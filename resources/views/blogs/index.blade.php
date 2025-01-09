<!-- resources/views/auth/register.blade.php -->
@extends('layouts.guest')

@section('content')
    <!-- Contenu principal -->
    <div class="container pt-16 mx-auto px-4"> <!-- Ajout de pt-16 pour compenser la navbar fixe -->
        <h1 class="text-center text-3xl font-bold my-8">Liste des blogs</h1>

        <div class="flex flex-wrap -mx-4">
            @foreach ($blogs as $blog)
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden h-full transition-transform transform hover:-translate-y-2 hover:shadow-lg">
                        <!-- Image de couverture -->
                        @if ($blog->FeaturedImage)
                        <img src="{{ asset('storage/' . $blog->FeaturedImage) }}" alt="Image mise en avant" class="w-full h-48 object-cover">                        @else
                            <div class="text-center py-12 bg-gray-100">
                                <i class="fas fa-image fa-3x text-gray-400"></i>
                                <p class="mt-2 text-gray-500">Aucune image</p>
                            </div>
                        @endif

                        <div class="p-6">
                            <!-- Catégorie -->
                            <span class="inline-block bg-blue-500 text-white text-sm px-2 py-1 rounded-full mb-4">
                                {{ $blog->Category }}
                            </span>

                            <!-- Titre -->
                            <h5 class="text-xl font-semibold mb-2">{{ $blog->Title }}</h5>

                            <!-- Contenu tronqué -->
                            <p class="text-gray-700">{{ Str::limit(strip_tags($blog->Content), 100) }}</p>

                            <!-- Auteur et date -->
                            <div class="flex justify-between items-center mt-4 text-sm text-gray-600">
                                <div>
                                    <i class="fas fa-user"></i> {{ $blog->author->Username ?? 'Auteur inconnu' }}
                                </div>
                                <div>
                                    <i class="fas fa-calendar-alt"></i> {{ $blog->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Bouton "Lire la suite" -->
                        <div class="bg-gray-50 p-4">
                            <a href="{{ route('blogs.show', $blog->BlogID) }}" class="block text-center border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white px-4 py-2 rounded transition-colors">
                                Lire la suite <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection