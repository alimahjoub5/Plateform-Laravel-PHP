@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Section à imprimer -->
    <div id="printable-section" class="card my-4">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">Devis #{{ $devis->Reference }}</h1>
        </div>
        <div class="card-body">
            <!-- Informations du Client -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="h5">Client</h2>
                    <p class="mb-1"><strong>Nom :</strong> {{ $devis->client->Username ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Email :</strong> {{ $devis->client->Email ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Téléphone :</strong> {{ $devis->client->Phone ?? 'Non spécifié' }}</p>
                </div>
                <div class="col-md-6">
                    <h2 class="h5">Projet</h2>
                    <p class="mb-1"><strong>Titre :</strong> {{ $devis->project->Title ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Description :</strong> {{ $devis->project->Description ?? 'Non spécifié' }}</p>
                </div>
            </div>

            <!-- Informations du Créateur -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="h6 mb-0">
                        <i class="fas fa-user-circle mr-2"></i> Créé par
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Nom :</strong> {{ $devis->createdBy->Username ?? 'Non spécifié' }}</p>
                            <p class="mb-2"><strong>Email :</strong> {{ $devis->createdBy->Email ?? 'Non spécifié' }}</p>
                            <p class="mb-0"><strong>Rôle :</strong> {{ $devis->createdBy->Role ?? 'Non spécifié' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Date de création :</strong> {{ $devis->created_at->format('d/m/Y H:i') ?? 'Non spécifié' }}</p>
                            <p class="mb-0"><strong>Dernière mise à jour :</strong> {{ $devis->updated_at->format('d/m/Y H:i') ?? 'Non spécifié' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails du Devis -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="h5">Informations du Devis</h2>
                    <p class="mb-1"><strong>Date d'émission :</strong> {{ $devis->DateEmission ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Date de validité :</strong> {{ $devis->DateValidite ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Statut :</strong> 
                        <span class="badge 
                            @if($devis->Statut == 'En attente') badge-warning
                            @elseif($devis->Statut == 'Accepté') badge-success
                            @elseif($devis->Statut == 'Refusé') badge-danger
                            @else badge-secondary
                            @endif">
                            {{ $devis->Statut }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <h2 class="h5">Totaux</h2>
                    <p class="mb-1"><strong>Total HT :</strong> {{ number_format($devis->TotalHT, 2, ',', ' ') }} €</p>
                    <p class="mb-1"><strong>TVA ({{ $devis->TVA }}%) :</strong> {{ number_format($devis->TotalHT * ($devis->TVA / 100), 2, ',', ' ') }} €</p>
                    <p class="mb-1"><strong>Total TTC :</strong> {{ number_format($devis->TotalTTC, 2, ',', ' ') }} €</p>
                </div>
            </div>

            <!-- Conditions Générales -->
            <div class="mb-4">
                <h2 class="h5">Conditions Générales</h2>
                <div class="border p-3 bg-light">
                    {!! nl2br(html_entity_decode($devis->ConditionsGenerales)) !!}
                </div>
            </div>

            <!-- Informations de Contact -->
            <div class="mb-4">
                <h2 class="h5">Informations de Contact</h2>
                <div class="border p-3 bg-light">
                    <p class="mb-1"><strong>Téléphone :</strong> {{ $contactInfo->phone ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Email :</strong> {{ $contactInfo->email ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Adresse :</strong> {{ $contactInfo->address ?? 'Non spécifié' }}</p>
                    <p class="mb-1"><strong>Heures de travail :</strong> {{ $contactInfo->working_hours ?? 'Non spécifié' }}</p>
                </div>
            </div>

                       <!-- Signature -->
                       <div class="signature">
                        <h2>Signature</h2>
                        @if ($devis->Statut == 'Accepté')
                            <!-- Afficher la signature si le devis est déjà accepté -->
                            <p>Signature du client :</p>
                            <img src="data:image/png;base64,{{ $devis->signature }}" alt="Signature du client" style="max-width: 15%; height: auto; border: 0px solid #000;">
                            <p>Date : {{ $devis->updated_at }}</p> <!-- Afficher la date actuelle -->
                        @elseif ($devis->Statut == 'En attente')
                            <!-- Pad de signature et boutons d'action -->
                            <div id="signature-pad" class="border p-3 bg-light mb-3">
                                <canvas id="signature-canvas" style="width: 100%; height: 200px; border: 1px solid #000;"></canvas>
                                <button id="clear-signature" class="btn btn-secondary mt-2">Effacer</button>
                            </div>
                            <form action="{{ route('client.devis.action', $devis->DevisID) }}" method="POST" id="devis-action-form">
                                @csrf
                                <input type="hidden" name="signature" id="signature-input">
                                
                                <!-- Boutons d'action -->
                                <button type="submit" name="action" value="accept" class="btn btn-success">
                                    <i class="fas fa-check"></i> Accepter le devis
                                </button>
                                <button type="submit" name="action" value="reject" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Refuser le devis
                                </button>
                            </form>
                        @else
                            <p>Devis refusé.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Inclure Signature Pad -->
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        
        <!-- Script pour gérer la signature -->
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('signature-canvas');
            const signaturePad = new SignaturePad(canvas);
        
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
                    // Convertir la signature en base64
                    const signatureInput = document.getElementById('signature-input');
                    const signatureData = signaturePad.toDataURL(); // Convertir en base64
                    signatureInput.value = signatureData;
                }
            });
        });
        </script>
        @endsection