@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Mes Devis</h1>

    @if ($devis->isEmpty())
        <div class="alert alert-info">
            Vous n'avez aucun devis pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Projet</th>
                        <th>Date d'émission</th>
                        <th>Date de validité</th>
                        <th>Total HT</th>
                        <th>TVA</th>
                        <th>Total TTC</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devis as $devi)
                    <tr>
                        <td>{{ $devi->Reference }}</td>
                        <td>{{ $devi->project->Title }}</td>
                        <td>{{ \Carbon\Carbon::parse($devi->DateEmission)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($devi->DateValidite)->format('d/m/Y') }}</td>
                        <td>{{ number_format($devi->TotalHT, 2, ',', ' ') }} €</td>
                        <td>{{ number_format($devi->TVA, 2, ',', ' ') }} €</td>
                        <td>{{ number_format($devi->TotalTTC, 2, ',', ' ') }} €</td>
                        <td>
                            <span class="badge 
                                @if($devi->Statut == 'En attente') badge-warning
                                @elseif($devi->Statut == 'Accepté') badge-success
                                @elseif($devi->Statut == 'Refusé') badge-danger
                                @else badge-secondary
                                @endif">
                                {{ $devi->Statut }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('client.devis.show', $devi) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                            <a href="{{ route('client.devis.download', $devi) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
<form action="{{ route('payment.process', 1) }}" method="POST" id="payment-form">
    @csrf
    <div id="card-element">
        <!-- Stripe Card Element sera injecté ici -->
    </div>
    <button id="submit-button" class="btn btn-primary mt-3">Payer</button>
</form>
@endsection