@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Créer un témoignage</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('testimonials.store') }}" method="POST">
                        @csrf
                        <!-- Champ caché pour l'ID du client (utilisateur connecté) -->
                        <input type="hidden" name="ClientID" value="{{ $user->UserID }}">

                        <!-- Sélection du projet -->
                        <div class="form-group mb-4">
                            <label for="ProjectID" class="form-label fw-bold">Projet</label>
                            <select name="ProjectID" id="ProjectID" class="form-select">
                                @foreach ($projects as $project)
                                <option value="{{ $project->ProjectID }}" {{ $selectedProject && $selectedProject->ProjectID == $project->ProjectID ? 'selected' : '' }}>
                                    {{ $project->Title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Feedback -->
                        <div class="form-group mb-4">
                            <label for="Feedback" class="form-label fw-bold">Feedback</label>
                            <textarea name="Feedback" id="Feedback" class="form-control" rows="4" placeholder="Décrivez votre expérience..." required></textarea>
                        </div>

                        <!-- Sélecteur d'étoiles -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Note</label>
                            <div class="rating">
                                <input type="radio" id="star5" name="Rating" value="5" required />
                                <label for="star5" title="5 étoiles">&#9733;</label>
                                <input type="radio" id="star4" name="Rating" value="4" />
                                <label for="star4" title="4 étoiles">&#9733;</label>
                                <input type="radio" id="star3" name="Rating" value="3" />
                                <label for="star3" title="3 étoiles">&#9733;</label>
                                <input type="radio" id="star2" name="Rating" value="2" />
                                <label for="star2" title="2 étoiles">&#9733;</label>
                                <input type="radio" id="star1" name="Rating" value="1" />
                                <label for="star1" title="1 étoile">&#9733;</label>
                            </div>
                            <small id="ratingText" class="form-text text-muted">Sélectionnez une note entre 1 et 5 étoiles.</small>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i> Soumettre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Styles pour la carte */
    .card {
        border: none;
        border-radius: 10px;
    }

    .card-header {
        border-radius: 10px 10px 0 0;
    }

    /* Styles pour le sélecteur d'étoiles */
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-start;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 2.5rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
    }

    .rating label:hover,
    .rating label:hover ~ label,
    .rating input:checked ~ label {
        color: #ffc107; /* Couleur des étoiles sélectionnées ou survolées */
    }

    .rating input:checked + label {
        color: #ffc107; /* Couleur de l'étoile sélectionnée */
        transform: scale(1.1); /* Animation légère */
    }

    /* Styles pour le texte dynamique de la note */
    #ratingText {
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('scripts')
<script>
    // Afficher la note sélectionnée dynamiquement
    document.querySelectorAll('.rating input').forEach(input => {
        input.addEventListener('change', (e) => {
            const ratingValue = e.target.value;
            document.getElementById('ratingText').textContent = `Vous avez sélectionné ${ratingValue}/5 étoiles.`;
        });
    });
</script>
@endsection