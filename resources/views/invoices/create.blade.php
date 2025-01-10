@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Créer une facture</h1>

    <!-- Afficher les erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de création de facture -->
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <!-- Champ caché pour l'ID du projet -->
        <input type="hidden" name="ProjectID" value="{{ $project->ProjectID }}">

        <!-- Champ caché pour l'ID du client -->
        <input type="hidden" name="ClientID" value="{{ $client->UserID }}">

        <!-- Champ Montant -->
        <div class="form-group">
            <label for="Amount">Montant (€)</label>
            <input type="number" step="0.01" class="form-control" id="Amount" name="Amount" required>
        </div>

        <!-- Champ Date d'échéance -->
        <div class="form-group">
            <label for="DueDate">Date d'échéance</label>
            <input type="date" class="form-control" id="DueDate" name="DueDate" required>
        </div>

        <!-- Champ Statut -->
        <div class="form-group">
            <label for="Status">Statut</label>
            <select class="form-control" id="Status" name="Status" required>
                <option value="Pending">En attente</option>
                <option value="Paid">Payé</option>
                <option value="Overdue">En retard</option>
            </select>
        </div>

        <!-- Champ Description -->
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea class="form-control" id="Description" name="Description" rows="4"></textarea>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Enregistrer la facture
        </button>

        <!-- Bouton d'annulation -->
        <a href="{{ route('projects.show', $project->ProjectID) }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Annuler
        </a>
    </form>
</div>

<!-- Inclure Font Awesome pour les icônes -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection