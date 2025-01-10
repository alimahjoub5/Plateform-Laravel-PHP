@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Liste des Devis</h1>

    <!-- Bouton pour créer un nouveau devis -->
    <a href="{{ route('devis.create') }}" class="btn btn-primary mb-4">
        <i class="fas fa-plus"></i> Créer un nouveau devis
    </a>

    <!-- Tableau des devis -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Référence</th>
                    <th scope="col">Client</th>
                    <th scope="col">Projet</th>
                    <th scope="col">Total TTC</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($devis as $devi)
                <tr>
                    <td>{{ $devi->Reference }}</td>
                    <td>{{ $devi->client->Username }}</td>
                    <td>{{ $devi->project->Title }}</td>
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
                        <!-- Bouton Voir -->
                        <a href="{{ route('devis.show', $devi->DevisID) }}" class="btn btn-sm btn-info" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Bouton Modifier -->
                        <a href="{{ route('devis.edit', $devi->DevisID) }}" class="btn btn-sm btn-warning" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Bouton Supprimer -->
                        <form action="{{ route('devis.destroy', $devi->DevisID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                        <!-- Bouton Ajouter une facture (visible seulement si le statut est "Accepté") -->
                        @if($devi->Statut == 'Accepté')
                            <a href="{{ route('invoices.index', ['projectID' => $devi->ProjectID,'ClientID' => $devi->client->UserID]) }}" class="btn btn-sm btn-success" title="Ajouter une facture">
                                <i class="fas fa-file-invoice"></i> Facture
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