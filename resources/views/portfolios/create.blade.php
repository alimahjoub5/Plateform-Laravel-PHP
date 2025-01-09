@extends('layouts.app')

@section('title', 'Créer un Portfolio')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Créer un nouveau Portfolio</h1>
        <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Champ Projet -->
            <div class="form-group mb-3">
                <label for="ProjectID" class="form-label">Projet</label>
                <select name="ProjectID" class="form-control @error('ProjectID') is-invalid @enderror" required>
                    <option value="">Sélectionnez un projet terminé</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->ProjectID }}" {{ old('ProjectID') == $project->ProjectID ? 'selected' : '' }}>
                            {{ $project->Title }}
                        </option>
                    @endforeach
                </select>
                @error('ProjectID')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Champ Titre -->
            <div class="form-group mb-3">
                <label for="Title" class="form-label">Titre</label>
                <input type="text" name="Title" class="form-control @error('Title') is-invalid @enderror" value="{{ old('Title') }}" required>
                @error('Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Champ Description -->
            <div class="form-group mb-3">
                <label for="Description" class="form-label">Description</label>
                <textarea name="Description" class="form-control @error('Description') is-invalid @enderror" required>{{ old('Description') }}</textarea>
                @error('Description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Champ Image -->
            <div class="form-group mb-3">
                <label for="ImageURL" class="form-label">Image</label>
                <input type="file" name="ImageURL" class="form-control @error('ImageURL') is-invalid @enderror">
                @error('ImageURL')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Champ Lien en direct -->
            <div class="form-group mb-3">
                <label for="LiveLink" class="form-label">Lien en direct</label>
                <input type="text" name="LiveLink" class="form-control @error('LiveLink') is-invalid @enderror" value="{{ old('LiveLink') }}">
                @error('LiveLink')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Champ Catégorie -->
            <div class="form-group mb-3">
                <label for="Category" class="form-label">Catégorie</label>
                <select name="Category" class="form-control @error('Category') is-invalid @enderror" required>
                    <option value="Web Development" {{ old('Category') == 'Web Development' ? 'selected' : '' }}>Développement Web</option>
                    <option value="Mobile App" {{ old('Category') == 'Mobile App' ? 'selected' : '' }}>Application Mobile</option>
                    <option value="Design" {{ old('Category') == 'Design' ? 'selected' : '' }}>Design</option>
                    <option value="Other" {{ old('Category') == 'Other' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('Category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

<!-- Champ Tags avec des boutons à cocher -->
<div class="form-group mb-3">
    <label class="form-label">Tags</label>
    <div>
        @foreach ($tags as $tag)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="Tags[]" id="tag_{{ $tag }}" value="{{ $tag }}"
                    {{ in_array($tag, json_decode(old('Tags', '[]'), true)) ? 'checked' : '' }}>
                <label class="form-check-label" for="tag_{{ $tag }}">{{ $tag }}</label>
            </div>
        @endforeach
    </div>
    @error('Tags')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <small class="form-text text-muted">Sélectionnez un ou plusieurs tags.</small>
</div>

<!-- Bouton de soumission -->
<div class="form-group mb-3">
    <button type="submit" class="btn btn-primary">Créer</button>
    <a href="{{ route('portfolios.index') }}" class="btn btn-secondary">Annuler</a>
</div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(function() {
            // Activer l'autocomplete sur le champ Tags
            $("#Tags").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('tags.autocomplete') }}",
                        dataType: "json",
                        data: {
                            term: request.term // Le terme saisi par l'utilisateur
                        },
                        success: function(data) {
                            response(data); // Renvoyer les suggestions
                        }
                    });
                },
                minLength: 1, // Nombre minimum de caractères avant de déclencher l'autocomplete
                select: function(event, ui) {
                    // Ajouter le tag sélectionné au champ Tags
                    let currentTags = $("#Tags").val();
                    if (currentTags) {
                        $("#Tags").val(currentTags + ", " + ui.item.value);
                    } else {
                        $("#Tags").val(ui.item.value);
                    }
                    return false; // Empêcher l'ajout automatique du tag
                }
            });
        });
    </script>
    @endpush
@endsection