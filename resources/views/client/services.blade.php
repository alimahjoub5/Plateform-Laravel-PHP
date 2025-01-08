@extends('layouts.app') <!-- Assurez-vous d'utiliser votre layout principal -->

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <!-- En-tête -->
                        <div class="text-center mb-5">
                            <i class="fas fa-list-alt fa-4x text-primary mb-3"></i>
                            <h1 class="display-5 fw-bold">Mes services demandés</h1>
                            <p class="lead text-muted">
                                Voici la liste des services que vous avez demandés, organisés par état.
                            </p>
                        </div>

                        <!-- Afficher les projets groupés par état -->
                        @foreach ([
                            'pending' => ['En attente', 'Les projets en attente d\'approbation.', 'warning'],
                            'approved' => ['Approuvés', 'Les projets approuvés et prêts à commencer.', 'success'],
                            'rejected' => ['Rejetés', 'Les projets qui ont été rejetés.', 'danger'],
                            'in_progress' => ['En cours', 'Les projets en cours de réalisation.', 'info'],
                            'completed' => ['Terminés', 'Les projets qui ont été complétés.', 'primary'],
                            'cancelled' => ['Annulés', 'Les projets qui ont été annulés.', 'secondary'],
                        ] as $key => [$title, $description, $color])
                            @if ($groupedProjects[$key]->isNotEmpty())
                                <div class="mb-5">
                                    <h2 class="h4 fw-bold text-{{ $color }}">
                                        <i class="fas fa-folder me-2"></i> {{ $title }}
                                    </h2>
                                    <p class="text-muted mb-3">{{ $description }}</p>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Titre</th>
                                                    <th>Description</th>
                                                    <th>Budget</th>
                                                    <th>Date limite</th>
                                                    <th>Statut</th>
                                                    <th>Approbation</th>
                                                    <th>Actions</th> <!-- Colonne pour les actions -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($groupedProjects[$key] as $project)
                                                    <tr>
                                                        <td>{{ $project->Title }}</td>
                                                        <td>{{ Str::limit($project->Description, 50) }}</td>
                                                        <td>${{ number_format($project->Budget, 2) }}</td>
                                                        <td>{{ $project->Deadline }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $project->Status === 'Pending' ? 'warning' : ($project->Status === 'In Progress' ? 'info' : ($project->Status === 'Completed' ? 'success' : 'secondary')) }}">
                                                                {{ $project->Status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $project->ApprovalStatus === 'Approved' ? 'success' : ($project->ApprovalStatus === 'Rejected' ? 'danger' : 'warning') }}">
                                                                {{ $project->ApprovalStatus }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if ($project->Status !== 'Cancelled' && $project->Status !== 'Completed' && $project->ApprovalStatus !== 'Rejected')
                                                                <form action="{{ route('projects.cancel', $project->ProjectID) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce projet ?')">
                                                                        <i class="fas fa-times-circle me-1"></i> Annuler
                                                                    </button>
                                                                </form>
                                                            @elseif ($project->ApprovalStatus === 'Rejected')
                                                                <span class="text-danger">
                                                                    <i class="fas fa-ban me-1"></i> Rejeté
                                                                </span>
                                                            @elseif ($project->Status === 'Completed')
                                                                <span class="text-success">
                                                                    <i class="fas fa-check-circle me-1"></i> Terminé
                                                                </span>
                                                            @elseif ($project->Status === 'Cancelled')
                                                                <span class="text-secondary">
                                                                    <i class="fas fa-times-circle me-1"></i> Annulé
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <!-- Bouton pour demander un nouveau service -->
                        <div class="text-center mt-5">
                            <a href="{{ route('client.request') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i> Demander un nouveau service
                            </a>
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

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #0b5ed7;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.9rem;
            transition: background 0.3s ease;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }
    </style>
@endsection