@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 text-sm text-gray-600">
            <h2 class="text-2xl font-bold text-center mb-4">Vérification de votre email</h2>
            <p class="mb-4">Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'e-mail, nous vous en enverrons un autre.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-4 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de l'inscription.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Renvoyer l'e-mail de vérification
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 