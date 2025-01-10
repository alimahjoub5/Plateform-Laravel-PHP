@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la facture #{{ $invoice->id }}</h1>
    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="client_id">Client</label>
            <select name="client_id" id="client_id" class="form-control" required>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Montant</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ $invoice->amount }}" required>
        </div>
        <div class="form-group">
            <label for="due_date">Date d'échéance</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $invoice->due_date->format('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control" required>
                <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Payée</option>
                <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Impayée</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection