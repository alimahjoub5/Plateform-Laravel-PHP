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

        <!-- Sélection du Client -->
        <div class="form-group">
            <label for="ClientID">Client :</label>
            <select name="ClientID" id="ClientID" class="form-control" required>
                @foreach ($clients as $client)
                <option value="{{ $client->UserID }}">
                    {{ $client->Username }} ({{ $client->Email }})
                </option>
                @endforeach
            </select>
            <small id="clientHelp" class="form-text text-muted">Sélectionnez le client pour ce devis.</small>
        </div>

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
            <input type="number" step="0.01" name="TotalHT" id="TotalHT" class="form-control" required>
        </div>

        <!-- TVA -->
        <div class="form-group">
            <label for="TVA">TVA (%) :</label>
            <input type="number" step="0.01" name="TVA" id="TVA" class="form-control" value="5" required>
        </div>

        <!-- Total TTC -->
        <div class="form-group">
            <label for="TotalTTC">Total TTC :</label>
            <input type="number" step="0.01" name="TotalTTC" id="TotalTTC" class="form-control" readonly>
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
        const totalTTC = document.getElementById('TotalTTC');
        const dateEmission = document.getElementById('DateEmission');
        const dateValidite = document.getElementById('DateValidite');
        const projectSelect = document.getElementById('ProjectID');
        const clientIdInput = document.getElementById('ClientID');

        // Mettre à jour le ClientID lors de la sélection d'un projet
        projectSelect.addEventListener('change', function() {
            const selectedOption = projectSelect.options[projectSelect.selectedIndex];
            const clientId = selectedOption.getAttribute('data-client-id');
            clientIdInput.value = clientId;
        });

        // Initialiser le ClientID avec la première option
        if (projectSelect.options.length > 0) {
            const firstOption = projectSelect.options[0];
            clientIdInput.value = firstOption.getAttribute('data-client-id');
        }

        // Calcul automatique du Total TTC
        function calculateTTC() {
            const ht = parseFloat(totalHT.value) || 0;
            const tvaRate = parseFloat(tva.value) || 0;
            const ttc = ht * (1 + tvaRate / 100);
            totalTTC.value = ttc.toFixed(2);
        }

        totalHT.addEventListener('input', calculateTTC);
        tva.addEventListener('input', calculateTTC);

        // Validation de la date de validité
        dateValidite.addEventListener('change', function () {
            if (new Date(dateValidite.value) <= new Date(dateEmission.value)) {
                alert('La date de validité doit être postérieure à la date d\'émission.');
                dateValidite.value = '';
            }
        });

        // Affichage des détails du projet sélectionné
        projectSelect.addEventListener('change', function () {
            const selectedOption = projectSelect.options[projectSelect.selectedIndex];
            const budget = selectedOption.getAttribute('data-budget');
            const deadline = selectedOption.getAttribute('data-deadline');
            console.log(`Projet sélectionné : Budget = ${budget} €, Deadline = ${deadline}`);
        });
    });
</script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialiser CKEditor sur le textarea avec l'id "ConditionsGenerales"
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

        // Écouter les changements dans CKEditor et sauvegarder dans localStorage
        CKEDITOR.instances.ConditionsGenerales.on('change', function () {
            const content = CKEDITOR.instances.ConditionsGenerales.getData();
            localStorage.setItem('conditionsGenerales', content);
        });

        // Suggestions automatiques
        const suggestionsDiv = document.getElementById('suggestions');
        const commonClauses = [
            "Paiement : 50% à la commande, 50% à la livraison.",
            "Délai de livraison : 30 jours à partir de la date de commande.",
            "Garantie : 12 mois à partir de la date de livraison.",
            "Résiliation : Tout retard de paiement entraîne des pénalités de 1,5% par mois."
        ];

        // Écouter les changements dans le textarea (avant l'initialisation de CKEditor)
        textarea.addEventListener('input', function () {
            const input = textarea.value.toLowerCase();
            suggestionsDiv.innerHTML = '';

            commonClauses.forEach(clause => {
                if (clause.toLowerCase().includes(input)) {
                    const suggestion = document.createElement('div');
                    suggestion.textContent = clause;
                    suggestion.classList.add('suggestion', 'p-2', 'mb-1', 'bg-light', 'cursor-pointer');
                    suggestion.addEventListener('click', function () {
                        const editor = CKEDITOR.instances.ConditionsGenerales;
                        const currentContent = editor.getData();
                        editor.setData(currentContent + '\n' + clause);
                        suggestionsDiv.innerHTML = '';
                    });
                    suggestionsDiv.appendChild(suggestion);
                }
            });
        });
    });
</script>
@endsection