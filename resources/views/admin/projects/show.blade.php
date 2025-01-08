@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <h1 class="display-5 fw-bold mb-4">Détails du projet</h1>

                        <div class="mb-4">
                            <p><strong>Titre :</strong> {{ $project->Title }}</p>
                            <p><strong>Description :</strong> {{ $project->Description }}</p>
                            <p><strong>Client :</strong> {{ $project->client->Username }}</p> <!-- Utiliser Username -->
                            <p><strong>Budget :</strong> ${{ number_format($project->Budget, 2) }}</p>
                            <p><strong>Date limite :</strong> {{ $project->Deadline }}</p>
                            <p><strong>Statut :</strong> {{ $project->Status }}</p>
                            <p><strong>Approbation :</strong> {{ $project->ApprovalStatus }}</p>
                        </div>

                        <!-- Afficher le formulaire d'affectation uniquement si le projet n'est pas déjà affecté -->
                        @if (!$project->ClientID)
                            <form action="{{ route('admin.projects.assign', $project->ProjectID) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Affecter à un utilisateur</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->UserID }}">{{ $user->Username }}</option> <!-- Utiliser Username -->
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i> Affecter
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info mb-4">
                                Ce projet est déjà affecté à l'utilisateur : <strong>{{ $project->client->Username }}</strong>.
                            </div>
                        @endif

                        <a href="{{ route('admin.projects') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection