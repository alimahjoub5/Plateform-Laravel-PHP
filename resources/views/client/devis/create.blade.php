@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Créer un nouveau devis</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.devis.store') }}" method="POST">
                        @csrf
                        
                        <!-- Informations du projet -->
                        <div class="mb-4">
                            <h3 class="h5 mb-3">Informations du projet</h3>
                            <div class="form-group">
                                <label for="project_id">Projet associé</label>
                                <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez un projet</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->ProjectID }}" {{ old('project_id') == $project->ProjectID ? 'selected' : '' }}>
                                            {{ $project->Title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Détails du devis -->
                        <div class="mb-4">
                            <h3 class="h5 mb-3">Détails du devis</h3>
                            
                            <div class="form-group">
                                <label for="reference">Référence du devis</label>
                                <input type="text" name="reference" id="reference" class="form-control @error('reference') is-invalid @enderror" 
                                       value="{{ old('reference') }}" required>
                                @error('reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date_emission">Date d'émission</label>
                                <input type="date" name="date_emission" id="date_emission" class="form-control @error('date_emission') is-invalid @enderror" 
                                       value="{{ old('date_emission', date('Y-m-d')) }}" required>
                                @error('date_emission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date_validite">Date de validité</label>
                                <input type="date" name="date_validite" id="date_validite" class="form-control @error('date_validite') is-invalid @enderror" 
                                       value="{{ old('date_validite') }}" required>
                                @error('date_validite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tva">TVA (%)</label>
                                <input type="number" name="tva" id="tva" class="form-control @error('tva') is-invalid @enderror" 
                                       value="{{ old('tva', 20) }}" min="0" max="100" step="0.01" required>
                                @error('tva')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Lignes du devis -->
                        <div class="mb-4">
                            <h3 class="h5 mb-3">Lignes du devis</h3>
                            <div id="devis-lignes">
                                <!-- Les lignes seront ajoutées dynamiquement ici -->
                            </div>
                            <button type="button" class="btn btn-secondary" id="add-ligne">
                                <i class="fas fa-plus"></i> Ajouter une ligne
                            </button>
                        </div>

                        <!-- Conditions générales -->
                        <div class="mb-4">
                            <h3 class="h5 mb-3">Conditions générales</h3>
                            <div class="form-group">
                                <textarea name="conditions_generales" id="conditions_generales" class="form-control @error('conditions_generales') is-invalid @enderror" 
                                          rows="5" required>{{ old('conditions_generales') }}</textarea>
                                @error('conditions_generales')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('client.devis.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le devis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template pour une ligne de devis -->
<template id="ligne-template">
    <div class="ligne-devis border p-3 mb-3">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="lignes[][description]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Quantité</label>
                    <input type="number" name="lignes[][quantite]" class="form-control" min="1" value="1" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Prix unitaire HT</label>
                    <input type="number" name="lignes[][prix_unitaire]" class="form-control" min="0" step="0.01" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Total HT</label>
                    <input type="text" class="form-control total-ht" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Actions</label>
                    <button type="button" class="btn btn-danger btn-block remove-ligne">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const devisLignes = document.getElementById('devis-lignes');
    const addLigneBtn = document.getElementById('add-ligne');
    const ligneTemplate = document.getElementById('ligne-template');

    // Ajouter une ligne
    addLigneBtn.addEventListener('click', function() {
        const ligne = ligneTemplate.content.cloneNode(true);
        devisLignes.appendChild(ligne);
        updateTotals();
    });

    // Supprimer une ligne
    devisLignes.addEventListener('click', function(e) {
        if (e.target.closest('.remove-ligne')) {
            e.target.closest('.ligne-devis').remove();
            updateTotals();
        }
    });

    // Calculer les totaux
    function updateTotals() {
        document.querySelectorAll('.ligne-devis').forEach(ligne => {
            const quantite = parseFloat(ligne.querySelector('[name$="[quantite]"]').value) || 0;
            const prixUnitaire = parseFloat(ligne.querySelector('[name$="[prix_unitaire]"]').value) || 0;
            const totalHT = quantite * prixUnitaire;
            ligne.querySelector('.total-ht').value = totalHT.toFixed(2);
        });
    }

    // Écouter les changements de quantité et prix
    devisLignes.addEventListener('input', function(e) {
        if (e.target.matches('[name$="[quantite]"], [name$="[prix_unitaire]"]')) {
            updateTotals();
        }
    });

    // Ajouter une ligne initiale
    addLigneBtn.click();
});
</script>
@endpush
@endsection 