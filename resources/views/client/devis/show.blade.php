@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-white">Devis #{{ $devis->Reference }}</h1>
                    <div class="space-x-2">
                        <a href="{{ route('client.devis.index') }}" 
                            class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i> Retour
                        </a>
                        <a href="{{ route('client.devis.download', $devis) }}" 
                            class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <i class="fas fa-download mr-2"></i> Télécharger
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contenu -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    <!-- Informations du Client et du Projet -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Client -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-3">Client</h2>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Nom :</span> {{ $devis->client->Username ?? 'Non spécifié' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Email :</span> {{ $devis->client->Email ?? 'Non spécifié' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Téléphone :</span> {{ $devis->client->Phone ?? 'Non spécifié' }}
                                </p>
                            </div>
                        </div>

                        <!-- Projet -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-3">Projet</h2>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Titre :</span> {{ $devis->project->Title ?? 'Non spécifié' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Description :</span> {{ $devis->project->Description ?? 'Non spécifié' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations du Créateur -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Créé par</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Nom :</span> {{ $devis->createdBy->Username ?? 'Non spécifié' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Email :</span> {{ $devis->createdBy->Email ?? 'Non spécifié' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Rôle :</span> {{ $devis->createdBy->Role ?? 'Non spécifié' }}
                                </p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Date de création :</span> {{ $devis->created_at->format('d/m/Y H:i') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Dernière mise à jour :</span> {{ $devis->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Détails du Devis -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-3">Informations du Devis</h2>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Date d'émission :</span> {{ $devis->DateEmission }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Date de validité :</span> {{ $devis->DateValidite }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Statut :</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($devis->Statut == 'En attente') bg-yellow-100 text-yellow-800
                                        @elseif($devis->Statut == 'Accepté') bg-green-100 text-green-800
                                        @elseif($devis->Statut == 'Refusé') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $devis->Statut }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Totaux -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-3">Totaux</h2>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Total HT :</span> {{ number_format($devis->TotalHT, 2, ',', ' ') }} €
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">TVA ({{ $devis->TVA }}%) :</span> {{ number_format($devis->TotalHT * ($devis->TVA / 100), 2, ',', ' ') }} €
                                </p>
                                <p class="text-sm font-medium text-gray-900">
                                    <span class="font-medium">Total TTC :</span> {{ number_format($devis->TotalTTC, 2, ',', ' ') }} €
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions Générales -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Conditions Générales</h2>
                        <div class="prose max-w-none text-sm text-gray-600">
                            {!! nl2br(html_entity_decode($devis->ConditionsGenerales)) !!}
                        </div>
                    </div>

                    <!-- Informations de Contact -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Informations de Contact</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Téléphone :</span> {{ $contactInfo->phone ?? 'Non spécifié' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Email :</span> {{ $contactInfo->email ?? 'Non spécifié' }}
                                </p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Adresse :</span> {{ $contactInfo->address ?? 'Non spécifié' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Heures de travail :</span> {{ $contactInfo->working_hours ?? 'Non spécifié' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Section de Négociation -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Négociation</h2>
                        
                        <!-- Historique des messages -->
                        <div class="space-y-4 mb-6">
                            @forelse($devis->negotiations ?? [] as $negotiation)
                                <div class="flex {{ $negotiation->sender_type === 'client' ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-2xl {{ $negotiation->sender_type === 'client' ? 'bg-blue-100' : 'bg-gray-100' }} rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium {{ $negotiation->sender_type === 'client' ? 'text-blue-800' : 'text-gray-800' }}">
                                                {{ $negotiation->sender_type === 'client' ? 'Vous' : 'Administrateur' }}
                                            </span>
                                            <span class="mx-2 text-gray-400">•</span>
                                            <span class="text-sm text-gray-500">
                                                {{ $negotiation->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                        <p class="text-sm {{ $negotiation->sender_type === 'client' ? 'text-blue-900' : 'text-gray-900' }}">
                                            {{ $negotiation->message }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 text-sm py-4">
                                    Aucun message de négociation pour le moment
                                </div>
                            @endforelse
                        </div>

                        <!-- Formulaire d'envoi de message -->
                        @if($devis->Statut == 'En attente')
                            <form action="{{ route('client.devis.negotiate', $devis->DevisID) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                        Votre message
                                    </label>
                                    <textarea
                                        id="message"
                                        name="message"
                                        rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Écrivez votre message de négociation ici..."
                                        required
                                    ></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                                    >
                                        <i class="fas fa-paper-plane mr-2"></i> Envoyer
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center text-gray-500 text-sm py-4">
                                La négociation n'est disponible que pour les devis en attente
                            </div>
                        @endif
                    </div>

                    <!-- Signature -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Signature</h2>
                        @if ($devis->Statut == 'Accepté')
                            <div class="flex items-center space-x-4">
                                <img src="data:image/png;base64,{{ $devis->signature }}" 
                                    alt="Signature du client" 
                                    class="h-16 w-auto">
                                <div class="text-sm text-gray-600">
                                    <p class="font-medium">Signature du client</p>
                                    <p>Date : {{ $devis->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @elseif ($devis->Statut == 'En attente')
                            <div class="space-y-4">
                                <div class="border rounded-lg p-4 bg-white">
                                    <canvas id="signature-canvas" class="w-full h-48 border rounded-lg"></canvas>
                                    <button id="clear-signature" 
                                        class="mt-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200">
                                        Effacer
                                    </button>
                                </div>
                                <form action="{{ route('client.devis.action', $devis->DevisID) }}" method="POST" id="devis-action-form" class="flex space-x-4">
                                    @csrf
                                    <input type="hidden" name="signature" id="signature-input">
                                    <button type="submit" name="action" value="accept" 
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                        <i class="fas fa-check mr-2"></i> Accepter le devis
                                    </button>
                                    <button type="submit" name="action" value="reject" 
                                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                        <i class="fas fa-times mr-2"></i> Refuser le devis
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-600">Devis refusé.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclure Font Awesome et Signature Pad -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<!-- Script pour gérer la signature -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('signature-canvas');
    if (canvas) {
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });

        // Effacer la signature
        document.getElementById('clear-signature').addEventListener('click', function (e) {
            e.preventDefault();
            signaturePad.clear();
        });

        // Soumettre la signature avec le formulaire
        const form = document.getElementById('devis-action-form');
        form.addEventListener('submit', function (e) {
            if (signaturePad.isEmpty()) {
                alert('Veuillez signer avant de soumettre.');
                e.preventDefault();
            } else {
                const signatureInput = document.getElementById('signature-input');
                const signatureData = signaturePad.toDataURL();
                signatureInput.value = signatureData;
            }
        });
    }
});
</script>
@endsection