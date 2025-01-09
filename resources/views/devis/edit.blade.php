@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Modifier le Devis</h1>

    <form action="{{ route('devis.update', $devis->DevisID) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Informations du Créateur -->
        <div class="form-group">
            <label for="CreatedBy">Créé par :</label>
            <input type="text" class="form-control" value="{{ $devis->createdBy->Username ?? 'Non spécifié' }}" readonly>
        </div>

        <!-- Sélection du Projet -->
        <div class="form-group">
            <label for="ProjectID">Projet :</label>
            <select name="ProjectID" id="ProjectID" class="form-control" required>
                @foreach ($projects as $project)
                <option value="{{ $project->ProjectID }}" {{ $devis->ProjectID == $project->ProjectID ? 'selected' : '' }}>{{ $project->Title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sélection du Client -->
        <div class="form-group">
            <label for="ClientID">Client :</label>
            <select name="ClientID" id="ClientID" class="form-control" required>
                @foreach ($clients as $client)
                <option value="{{ $client->UserID }}" {{ $devis->ClientID == $client->UserID ? 'selected' : '' }}>{{ $client->Username }}</option>
                @endforeach
            </select>
        </div>

        <!-- Référence du Devis -->
        <div class="form-group">
            <label for="Reference">Référence :</label>
            <input type="text" name="Reference" id="Reference" class="form-control" value="{{ $devis->Reference }}" required>
        </div>

        <!-- Date d'émission -->
        <div class="form-group">
            <label for="DateEmission">Date d'émission :</label>
            <input type="date" name="DateEmission" id="DateEmission" class="form-control" value="{{ $devis->DateEmission }}" required>
        </div>

        <!-- Date de validité -->
        <div class="form-group">
            <label for="DateValidite">Date de validité :</label>
            <input type="date" name="DateValidite" id="DateValidite" class="form-control" value="{{ $devis->DateValidite }}" required>
        </div>

        <!-- Total HT -->
        <div class="form-group">
            <label for="TotalHT">Total HT :</label>
            <input type="number" step="0.01" name="TotalHT" id="TotalHT" class="form-control" value="{{ $devis->TotalHT }}" required>
        </div>

        <!-- TVA -->
        <div class="form-group">
            <label for="TVA">TVA (%) :</label>
            <input type="number" step="0.01" name="TVA" id="TVA" class="form-control" value="{{ $devis->TVA }}" required>
        </div>

        <!-- Total TTC -->
        <div class="form-group">
            <label for="TotalTTC">Total TTC :</label>
            <input type="number" step="0.01" name="TotalTTC" id="TotalTTC" class="form-control" value="{{ $devis->TotalTTC }}" readonly>
        </div>

        <!-- Conditions générales -->
        <div class="form-group">
            <label for="ConditionsGenerales">Conditions générales :</label>
            <textarea name="ConditionsGenerales" id="ConditionsGenerales" class="form-control">{{ $devis->ConditionsGenerales }}</textarea>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Mettre à jour
        </button>
    </form>
</div>

<!-- Inclure CKEditor pour les conditions générales -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialiser CKEditor sur le textarea avec l'id "ConditionsGenerales"
        CKEDITOR.replace('ConditionsGenerales', {
            height: 200, // Hauteur de l'éditeur
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'Source'] } // Option pour voir le code source
            ],
            removeButtons: 'Subscript,Superscript', // Boutons à désactiver
            language: 'fr', // Langue française
        });

        // Calcul automatique du Total TTC
        const totalHT = document.getElementById('TotalHT');
        const tva = document.getElementById('TVA');
        const totalTTC = document.getElementById('TotalTTC');

        function calculateTTC() {
            const ht = parseFloat(totalHT.value) || 0;
            const tvaRate = parseFloat(tva.value) || 0;
            const ttc = ht * (1 + tvaRate / 100);
            totalTTC.value = ttc.toFixed(2);
        }

        totalHT.addEventListener('input', calculateTTC);
        tva.addEventListener('input', calculateTTC);

        // Calcul initial au chargement de la page
        calculateTTC();
    });
</script>

<!-- Inclure Font Awesome pour les icônes -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection