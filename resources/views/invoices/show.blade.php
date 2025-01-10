@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Facture #{{ $invoice->id }}</h1>
    <p><strong>Client :</strong> {{ $invoice->client->name }}</p>
    <p><strong>Montant :</strong> {{ $invoice->amount }} €</p>
    <p><strong>Date d'échéance :</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
    <p><strong>Statut :</strong> {{ $invoice->status }}</p>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection