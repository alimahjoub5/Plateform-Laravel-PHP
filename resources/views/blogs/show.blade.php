@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Titre du blog -->
        <h1 class="text-4xl font-bold text-center text-gray-800 py-6">
            {{ $blog->Title }}
        </h1>

        <!-- Image mise en avant -->
        @if ($blog->FeaturedImage)
            <div class="flex justify-center">
                <img src="{{ asset('storage/' . $blog->FeaturedImage) }}" alt="Image mise en avant" class="rounded-lg shadow-md w-full max-w-2xl">
            </div>
        @endif

        <!-- Catégorie -->
        <div class="text-center mt-6">
            <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                <i class="fas fa-tag mr-2"></i>
                {{ $blog->Category }}
            </span>
        </div>

        <!-- Contenu du blog -->
        <div class="prose prose-lg max-w-none px-6 py-8">
            {!! $blog->Content !!}
        </div>
    </div>
</div>
@endsection