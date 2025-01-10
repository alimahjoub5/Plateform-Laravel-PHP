@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Facture #{{ $invoice->InvoiceID }}</h1>

    <!-- Informations sur la facture -->
    <div class="card">
        <div class="card-body">
            <p class="card-text"><strong>Client :</strong> {{ $invoice->client->Username }}</p>
            <p class="card-text"><strong>Description :</strong> {{ $invoice->Description }}</p>
            <p class="card-text"><strong>Projet :</strong> {{ $invoice->project->Title }}</p>
            <p class="card-text"><strong>Montant :</strong> {{ number_format($invoice->Amount, 2, ',', ' ') }} €</p>
            <p class="card-text"><strong>Date d'échéance :</strong> {{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}</p>
            <p class="card-text">
                <strong>Statut :</strong>
                <span class="badge 
                    @if($invoice->Status == 'Pending') badge-warning
                    @elseif($invoice->Status == 'Paid') badge-success
                    @elseif($invoice->Status == 'Overdue') badge-danger
                    @endif">
                    {{ $invoice->Status }}
                </span>
            </p>
        </div>
    </div>

    <!-- Bouton de retour -->
    <div class="mt-4">
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<!-- Inclure Font Awesome pour les icônes -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection