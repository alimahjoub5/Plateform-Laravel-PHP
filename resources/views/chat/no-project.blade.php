@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-8 text-center">
            <div class="mb-6">
                <i class="fas fa-project-diagram text-6xl text-blue-500"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Aucun projet trouvé</h1>
            <p class="text-gray-600 mb-6">
                Pour accéder au chat, vous devez d'abord avoir un projet actif. 
                Créez une demande de projet pour commencer à discuter avec notre équipe.
            </p>
            <div class="space-x-4">
                <a href="{{ route('client.request') }}" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300">
                    <i class="fas fa-plus-circle mr-2"></i> Créer une demande de projet
                </a>
                <a href="{{ route('home') }}" class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-300">
                    <i class="fas fa-home mr-2"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 