@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">Modifier la facture #{{ $invoice->InvoiceID }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('invoices.update', ['invoice' => $invoice->InvoiceID]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="Amount" class="form-label">Montant (€)</label>
                            <input type="number" step="0.01" class="form-control @error('Amount') is-invalid @enderror" 
                                id="Amount" name="Amount" value="{{ old('Amount', $invoice->Amount) }}" required>
                            @error('Amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="DueDate" class="form-label">Date d'échéance</label>
                            <input type="date" class="form-control @error('DueDate') is-invalid @enderror" 
                                id="DueDate" name="DueDate" value="{{ old('DueDate', $invoice->DueDate) }}" required>
                            @error('DueDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Status" class="form-label">Statut</label>
                            <select class="form-select @error('Status') is-invalid @enderror" 
                                id="Status" name="Status" required>
                                <option value="Pending" {{ $invoice->Status === 'Pending' ? 'selected' : '' }}>En attente</option>
                                <option value="Paid" {{ $invoice->Status === 'Paid' ? 'selected' : '' }}>Payée</option>
                                <option value="Overdue" {{ $invoice->Status === 'Overdue' ? 'selected' : '' }}>En retard</option>
                            </select>
                            @error('Status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Description" class="form-label">Description</label>
                            <textarea class="form-control @error('Description') is-invalid @enderror" 
                                id="Description" name="Description" rows="3">{{ old('Description', $invoice->Description) }}</textarea>
                            @error('Description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('invoices.show', ['invoice' => $invoice->InvoiceID]) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection