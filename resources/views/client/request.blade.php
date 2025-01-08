@extends('layouts.app') <!-- Assurez-vous d'utiliser votre layout principal -->

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <!-- En-tête amical -->
                        <div class="text-center mb-5">
                            <i class="fas fa-handshake fa-4x text-primary mb-3"></i>
                            <h1 class="display-5 fw-bold">Demandez-nous un service</h1>
                            <p class="lead text-muted">
                                Nous sommes là pour vous aider ! Remplissez ce formulaire, et nous vous répondrons rapidement.
                            </p>
                        </div>

                        <!-- Afficher les messages de succès ou d'erreur -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Formulaire de demande de projet -->
                        <form action="{{ route('client.submitRequest') }}" method="POST" class="needs-validation" novalidate>
                            @csrf <!-- Token CSRF pour la sécurité -->

                            <!-- Titre du projet -->
                            <div class="mb-4">
                                <label for="Title" class="form-label fw-bold">
                                    <i class="fas fa-heading me-2"></i> Titre du projet
                                </label>
                                <input type="text" name="Title" id="Title" class="form-control" value="{{ old('Title') }}" required>
                                @error('Title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description du projet -->
                            <div class="mb-4">
                                <label for="Description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-2"></i> Description du projet
                                </label>
                                <textarea name="Description" id="Description" class="form-control" rows="5" required>{{ old('Description') }}</textarea>
                                @error('Description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Budget estimé -->
                            <div class="mb-4">
                                <label for="Budget" class="form-label fw-bold">
                                    <i class="fas fa-coins me-2"></i> Budget estimé
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="Budget" id="Budget" class="form-control" value="{{ old('Budget') }}" required>
                                </div>
                                @error('Budget')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date limite -->
                            <div class="mb-4">
                                <label for="Deadline" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-2"></i> Date limite
                                </label>
                                <input type="date" name="Deadline" id="Deadline" class="form-control" value="{{ old('Deadline') }}" required>
                                @error('Deadline')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Envoyer la demande
                                </button>
                            </div>
                        </form>

                        <!-- Message de fin amical -->
                        <div class="text-center mt-5">
                            <p class="text-muted">
                                <i class="fas fa-heart text-danger"></i> Merci de faire confiance à notre équipe. Nous sommes impatients de travailler avec vous !
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Styles personnalisés */
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #0b5ed7;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            color: #dc3545;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .fa-handshake, .fa-heart {
            color: #0d6efd;
        }
    </style>
@endsection