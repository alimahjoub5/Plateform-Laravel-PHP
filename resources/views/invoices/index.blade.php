@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des factures</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Créer une facture</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Date d'échéance</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->InvoiceID }}</td>
                    <td>{{ $invoice->client->name }}</td> <!-- Assurez-vous que la colonne "name" existe dans la table "users" -->
                    <td>{{ $invoice->Amount }} €</td> <!-- Utilisez "Amount" au lieu de "amount" -->
                    <td>{{ $invoice->DueDate ? \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') : 'Non définie' }}</td> <!-- Utilisez "DueDate" et formatez-la -->
                    <td>{{ $invoice->Status }}</td> <!-- Utilisez "Status" au lieu de "status" -->
                    <td>
                        <a href="{{ route('invoices.show', $invoice->InvoiceID) }}" class="btn btn-info">Voir</a>
                        <a href="{{ route('invoices.edit', $invoice->InvoiceID) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('invoices.destroy', $invoice->InvoiceID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                        <!-- Bouton "Payer" -->
                        @if($invoice->Status === 'Pending') <!-- Utilisez "Status" au lieu de "status" -->
                            <a href="{{ route('payment.form', $invoice->InvoiceID) }}" class="btn btn-success mt-2">Payer</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection