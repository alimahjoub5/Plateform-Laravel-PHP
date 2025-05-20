@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">Facture #{{ $invoice->InvoiceID }}</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('invoices.pdf', ['invoice' => $invoice->InvoiceID]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf me-1"></i> Télécharger PDF
                            </a>
                            @if(Auth::user()->Role === 'Admin')
                                <a href="{{ route('invoices.edit', ['invoice' => $invoice->InvoiceID]) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Modifier
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- En-tête de la facture -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Informations de la facture</h6>
                            <p class="mb-1"><strong>Date de création :</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
                            <p class="mb-1"><strong>Date d'échéance :</strong> {{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}</p>
                            <p class="mb-1">
                                <strong>Statut :</strong>
                                <span class="badge bg-{{ $invoice->Status === 'Paid' ? 'success' : ($invoice->Status === 'Pending' ? 'warning' : 'danger') }}">
                                    {{ $invoice->Status }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-muted mb-2">Montant</h6>
                            <h4 class="text-primary mb-0">{{ number_format($invoice->Amount, 2, ',', ' ') }} €</h4>
                            <small class="text-muted">TTC</small>
                        </div>
                    </div>

                    <!-- Informations client -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Client</h6>
                                    <p class="mb-1"><strong>Nom :</strong> {{ $invoice->client->FirstName }} {{ $invoice->client->LastName }}</p>
                                    <p class="mb-1"><strong>Email :</strong> {{ $invoice->client->Email }}</p>
                                    <p class="mb-1"><strong>Téléphone :</strong> {{ $invoice->client->PhoneNumber }}</p>
                                    <p class="mb-0"><strong>Adresse :</strong> {{ $invoice->client->Address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Projet</h6>
                                    <p class="mb-1"><strong>Titre :</strong> {{ $invoice->project->Title }}</p>
                                    <p class="mb-1"><strong>Description :</strong> {{ $invoice->project->Description }}</p>
                                    <p class="mb-0"><strong>Budget :</strong> {{ number_format($invoice->project->Budget, 2, ',', ' ') }} €</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($invoice->Description)
                    <div class="card border-0 bg-light mb-4">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">Description</h6>
                            <p class="mb-0">{{ $invoice->Description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Historique des paiements -->
                    @if($invoice->payments->count() > 0)
                    <div class="card border-0 bg-light mb-4">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">Historique des paiements</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Méthode</th>
                                            <th>Montant</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>{{ number_format($payment->amount, 2, ',', ' ') }} €</td>
                                            <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $payment->status === 'Paid' ? 'success' : ($payment->status === 'Pending' ? 'warning' : 'danger') }}">
                                                    {{ $payment->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Coordonnées de paiement -->
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">Coordonnées de paiement</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Virement bancaire :</strong></p>
                                    <p class="mb-1">Banque : Banque de Développement</p>
                                    <p class="mb-1">IBAN : TN59 1000 6035 0000 1234 5678</p>
                                    <p class="mb-0">BIC / SWIFT : BDTTNTTT</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>PayPal :</strong></p>
                                    <p class="mb-1">paiement@entreprise.tn</p>
                                    <p class="mb-0 text-muted"><small>(Merci d'indiquer le numéro de la facture dans la note du paiement)</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection