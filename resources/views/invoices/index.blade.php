@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des factures</h1>

    <!-- Bouton pour créer une facture (visible uniquement pour l'admin) -->
    @if (Auth::user()->Role === 'Admin')
        <a href="{{ route('invoices.create', ['projectID' => 1]) }}" class="btn btn-primary mb-3">
            Créer une facture
        </a>
    @endif

    <!-- Afficher les messages de succès -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tableau des factures -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Projet</th>
                    <th>Montant (€)</th>
                    <th>Date d'échéance</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->InvoiceID }}</td>
                        <td>{{ $invoice->client->Username }}</td>
                        <td>{{ $invoice->project->Title }}</td>
                        <td>{{ number_format($invoice->Amount, 2, ',', ' ') }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge 
                                @if($invoice->Status == 'Pending') badge-warning
                                @elseif($invoice->Status == 'Paid') badge-success
                                @elseif($invoice->Status == 'Overdue') badge-danger
                                @endif">
                                {{ $invoice->Status }}
                            </span>
                        </td>
                        <td>
                            <!-- Bouton Voir -->
                            <a href="{{ route('invoices.show', $invoice->InvoiceID) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Bouton Modifier (visible uniquement pour l'admin) -->
                            @if (Auth::user()->Role === 'Admin')
                                <a href="{{ route('invoices.edit', $invoice->InvoiceID) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif

                            <!-- Bouton Supprimer (visible uniquement pour l'admin) -->
                            @if (Auth::user()->Role === 'Admin')
                                <form action="{{ route('invoices.destroy', $invoice->InvoiceID) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Bouton Payer (visible uniquement pour le client si la facture est en attente) -->
                            @if (Auth::user()->Role === 'Client' && $invoice->Status === 'Pending')
                                <a href="{{ route('payment.form', $invoice->InvoiceID) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-credit-card"></i> Payer
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Inclure Font Awesome pour les icônes -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection