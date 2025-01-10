@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Liste des Clients</h1>

    <!-- Liste des clients -->
    <div class="row">
        @foreach ($clients as $client)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <!-- En-tête de la carte client -->
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-circle mr-2"></i>{{ $client->Username }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Informations du client -->
                    <p class="card-text">
                        <strong><i class="fas fa-envelope mr-2"></i>Email :</strong> {{ $client->Email }}
                    </p>
                    <p class="card-text">
                        <strong><i class="fas fa-project-diagram mr-2"></i>Projets acceptés :</strong> {{ $client->projects->count() }}
                    </p>

                    <!-- Bouton pour afficher les détails -->
                    <button class="btn btn-outline-secondary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#client-{{ $client->UserID }}" aria-expanded="false" aria-controls="client-{{ $client->UserID }}">
                        <i class="fas fa-chevron-down mr-2"></i>Voir les détails
                    </button>
                </div>

                <!-- Détails du client (projets, devis, factures) -->
                <div class="collapse" id="client-{{ $client->UserID }}">
                    <div class="card-body bg-light p-3">
                        @foreach ($client->projects as $project)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-folder-open mr-2"></i>Projet : {{ $project->Title }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Liste des devis -->
                                    <div class="mb-3">
                                        <strong><i class="fas fa-file-invoice mr-2"></i>Devis :</strong>
                                        <ul class="list-group list-group-flush">
                                            @foreach ($project->devis as $devi)
                                                <li class="list-group-item p-2">
                                                    <i class="fas fa-file-alt mr-2"></i>
                                                    Référence : <strong>{{ $devi->Reference }}</strong>,
                                                    Statut : <span class="text-dark">{{ $devi->Statut }}</span>,
                                                    Montant : <strong>{{ number_format($devi->TotalTTC, 2, ',', ' ') }} €</strong>
                                                    <!-- Lien vers les détails du devis -->
                                                    <a href="{{ route('devis.show', $devi->DevisID) }}" class="btn btn-info btn-sm mt-2">
                                                        <i class="fas fa-eye mr-2"></i>Voir les détails
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Liste des factures -->
                                    <div class="mb-3">
                                        <strong><i class="fas fa-file-invoice-dollar mr-2"></i>Factures :</strong>
                                        <ul class="list-group list-group-flush">
                                            @foreach ($project->invoices as $invoice)
                                                <li class="list-group-item p-2">
                                                    <i class="fas fa-file-invoice mr-2"></i>
                                                    Montant : <strong>{{ number_format($invoice->Amount, 2, ',', ' ') }} €</strong>,
                                                    Statut : <span class="text-dark">{{ $invoice->Status }}</span>,
                                                    Échéance : <strong>{{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}</strong>
                                                    <!-- Bouton "Voir plus" pour les détails de la facture -->
                                                    <a href="{{ route('invoices.show', $invoice->InvoiceID) }}" class="btn btn-info btn-sm mt-2">
                                                        <i class="fas fa-eye mr-2"></i>Voir plus
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Inclure Bootstrap JS et Font Awesome -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection