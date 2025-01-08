@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <h1 class="display-5 fw-bold mb-4">Gestion des projets</h1>

                        @if ($projects->isEmpty())
                            <div class="alert alert-info">
                                Aucun projet n'a été trouvé.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Client</th>
                                            <th>Budget</th>
                                            <th>Date limite</th>
                                            <th>Statut</th>
                                            <th>Approbation</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td>{{ $project->Title }}</td>
                                                <td>{{ $project->client->name }}</td> <!-- Supposons que le client a un nom -->
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
                                                    <a href="{{ route('admin.projects.show', $project->ProjectID) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i> Voir
                                                    </a>
                                                    @if ($project->ApprovalStatus === 'Pending')
                                                        <form action="{{ route('admin.projects.approve', $project->ProjectID) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-check"></i> Approuver
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.projects.reject', $project->ProjectID) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-times"></i> Refuser
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection