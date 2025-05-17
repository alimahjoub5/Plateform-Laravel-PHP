@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un Devis</h1>

    @if ($projects->isEmpty())
    <div class="alert alert-info">
        Aucun projet disponible pour créer un devis.
    </div>
    @else
    <form action="{{ route('devis.store') }}" method="POST" id="devisForm">
        @csrf

        <!-- Sélection du Projet -->
        <div class="form-group">
            <label for="ProjectID">Projet :</label>
            <select name="ProjectID" id="ProjectID" class="form-control" required>
                @foreach ($projects as $project)
                <option value="{{ $project->ProjectID }}" 
                        data-budget="{{ $project->Budget }}" 
                        data-deadline="{{ $project->Deadline }}"
                        data-client-id="{{ $project->ClientID }}">
                    {{ $project->Title }} (Budget : {{ $project->Budget }} €, Deadline : {{ $project->Deadline }})
                </option>
                @endforeach
            </select>
            <small id="projectHelp" class="form-text text-muted">Sélectionnez un projet pour lequel créer un devis.</small>
        </div>

        <!-- Champ caché pour le ClientID -->
        <input type="hidden" name="ClientID" value="{{ auth()->user()->UserID }}">

        <!-- Référence du Devis -->
        <div class="form-group">
            <label for="Reference">Référence :</label>
            <input type="text" name="Reference" id="Reference" class="form-control" value="{{ $reference }}" readonly required>
            <small id="referenceHelp" class="form-text text-muted">Référence unique générée automatiquement.</small>
        </div>

        <!-- Date d'émission -->
        <div class="form-group">
            <label for="DateEmission">Date d'émission :</label>
            <input type="date" name="DateEmission" id="DateEmission" class="form-control" required>
        </div>

        <!-- Date de validité -->
        <div class="form-group">
            <label for="DateValidite">Date de validité :</label>
            <input type="date" name="DateValidite" id="DateValidite" class="form-control" required>
            <small id="dateValiditeHelp" class="form-text text-muted">La date de validité doit être postérieure à la date d'émission.</small>
        </div>

        <!-- Total HT -->
        <div class="form-group">
            <label for="TotalHT">Total HT :</label>
            <input type="number" step="0.01" min="0" name="TotalHT" id="TotalHT" class="form-control" required>
            <small class="text-muted">Montant hors taxes en euros (€)</small>
        </div>

        <!-- TVA -->
        <div class="form-group">
            <label for="TVA">TVA (%) :</label>
            <input type="number" step="0.01" min="0" max="100" name="TVA" id="TVA" class="form-control" value="19" required>
            <small class="text-muted">Taux de TVA en pourcentage (%)</small>
        </div>

        <!-- Montant TVA -->
        <div class="form-group">
            <label for="MontantTVA">Montant TVA :</label>
            <input type="number" step="0.01" name="MontantTVA" id="MontantTVA" class="form-control" readonly>
            <small class="text-muted">Montant de la TVA en euros (€)</small>
        </div>

        <!-- Total TTC -->
        <div class="form-group">
            <label for="TotalTTC">Total TTC :</label>
            <input type="number" step="0.01" name="TotalTTC" id="TotalTTC" class="form-control" readonly>
            <small class="text-muted">Montant toutes taxes comprises en euros (€)</small>
        </div>

        <!-- Conditions générales -->
        <div class="form-group">
            <label for="ConditionsGenerales">Conditions générales :</label>
            <textarea name="ConditionsGenerales" id="ConditionsGenerales" class="form-control">{{ $conditionsGenerales ?? '' }}</textarea>
            <small id="conditionsHelp" class="form-text text-muted">
                Exemples de clauses :<br>
                - Paiement : 50% à la commande, 50% à la livraison.<br>
                - Délai de livraison : 30 jours à partir de la date de commande.<br>
                - Garantie : 12 mois à partir de la date de livraison.<br>
                - Résiliation : Tout retard de paiement entraîne des pénalités de 1,5% par mois.
            </small>
            <div id="suggestions" class="mt-2"></div>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
    @endif
</div>

<!-- Script pour améliorer l'intelligence du formulaire -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('devisForm');
        const totalHT = document.getElementById('TotalHT');
        const tva = document.getElementById('TVA');
        const montantTVA = document.getElementById('MontantTVA');
        const totalTTC = document.getElementById('TotalTTC');
        const dateEmission = document.getElementById('DateEmission');
        const dateValidite = document.getElementById('DateValidite');
        const projectSelect = document.getElementById('ProjectID');

        // Initialiser la date d'émission à aujourd'hui
        const today = new Date().toISOString().split('T')[0];
        dateEmission.value = today;

        // Calcul automatique des totaux
        function calculateTotals() {
            const ht = parseFloat(totalHT.value) || 0;
            const tvaRate = parseFloat(tva.value) || 0;
            
            // Calcul du montant de la TVA
            const tvaAmount = (ht * tvaRate) / 100;
            montantTVA.value = tvaAmount.toFixed(2);
            
            // Calcul du total TTC
            const ttc = ht + tvaAmount;
            totalTTC.value = ttc.toFixed(2);
        }

        // Écouter les changements dans les champs de calcul
        totalHT.addEventListener('input', calculateTotals);
        tva.addEventListener('input', calculateTotals);

        // Validation de la date de validité
        dateValidite.addEventListener('change', function () {
            if (new Date(dateValidite.value) <= new Date(dateEmission.value)) {
                alert('La date de validité doit être postérieure à la date d\'émission.');
                dateValidite.value = '';
            }
        });

        // Suggestion du budget du projet
        projectSelect.addEventListener('change', function () {
            const selectedOption = projectSelect.options[projectSelect.selectedIndex];
            const budget = parseFloat(selectedOption.getAttribute('data-budget')) || 0;
            totalHT.value = budget.toFixed(2);
            calculateTotals();
        });

        // Validation du formulaire avant soumission
        form.addEventListener('submit', function(e) {
            const ht = parseFloat(totalHT.value) || 0;
            const tvaRate = parseFloat(tva.value) || 0;
            const ttc = parseFloat(totalTTC.value) || 0;

            if (ht <= 0) {
                e.preventDefault();
                alert('Le montant HT doit être supérieur à 0');
                return;
            }

            if (tvaRate < 0 || tvaRate > 100) {
                e.preventDefault();
                alert('Le taux de TVA doit être compris entre 0 et 100');
                return;
            }

            // Vérifier que le TTC est correct
            const expectedTTC = ht * (1 + tvaRate / 100);
            if (Math.abs(ttc - expectedTTC) > 0.01) {
                e.preventDefault();
                alert('Erreur dans le calcul du total TTC');
                return;
            }
        });
    });
</script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialiser CKEditor
        CKEDITOR.replace('ConditionsGenerales', {
            height: 300,
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'Source'] }
            ],
            removeButtons: 'Subscript,Superscript',
            language: 'fr',
        });

        // Sauvegarde automatique
        const textarea = document.getElementById('ConditionsGenerales');
        const savedText = localStorage.getItem('conditionsGenerales');
        if (savedText) {
            textarea.value = savedText;
        }

        CKEDITOR.instances.ConditionsGenerales.on('change', function () {
            const content = CKEDITOR.instances.ConditionsGenerales.getData();
            localStorage.setItem('conditionsGenerales', content);
        });
    });
</script>
@endsection