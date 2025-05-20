@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">Liste des factures</h5>
                        @if(Auth::user()->Role === 'Admin')
                            <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Nouvelle facture
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($invoices->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Aucune facture trouvée.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Facture</th>
                                        <th>Client</th>
                                        <th>Projet</th>
                                        <th>Montant</th>
                                        <th>Date d'échéance</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td>#{{ $invoice->InvoiceID }}</td>
                                            <td>{{ $invoice->client->FirstName }} {{ $invoice->client->LastName }}</td>
                                            <td>{{ $invoice->project->Title }}</td>
                                            <td>{{ number_format($invoice->Amount, 2, ',', ' ') }} €</td>
                                            <td>{{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $invoice->Status === 'Paid' ? 'success' : ($invoice->Status === 'Pending' ? 'warning' : 'danger') }}">
                                                    {{ $invoice->Status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('invoices.show', ['invoice' => $invoice->InvoiceID]) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('invoices.download', ['invoice' => $invoice->InvoiceID]) }}" 
                                                       class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                    @if(Auth::user()->Role === 'Admin')
                                                        <a href="{{ route('invoices.edit', ['invoice' => $invoice->InvoiceID]) }}" 
                                                           class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('invoices.destroy', ['invoice' => $invoice->InvoiceID]) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection