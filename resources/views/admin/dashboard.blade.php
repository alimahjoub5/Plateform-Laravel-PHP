@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de Bord Administrateur</h1>

    <!-- Section pour les statistiques générales -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total des Visites</h5>
                    <p class="card-text">{{ $totalVisits }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Utilisateurs Actifs</h5>
                    <p class="card-text">{{ $activeUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Appareils les Plus Utilisés</h5>
                    <p class="card-text">{{ $mostUsedDevice }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section pour les graphiques -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Visites par Page</h5>
                    <canvas id="pageVisitsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Actions des Utilisateurs</h5>
                    <canvas id="userActionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Section pour le tableau des données analytiques -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Données Analytiques</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Page Visitée</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                        <th>Type d'Appareil</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($analyticsData as $data)
                    <tr>
                        <td>{{ $data->AnalyticsID }}</td>
                        <td>{{ $data->PageVisited }}</td>
                        <td>{{ $data->user->name ?? 'Anonyme' }}</td>
                        <td>{{ $data->Action }}</td>
                        <td>{{ $data->DeviceType }}</td>
                        <td>{{ $data->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $analyticsData->links() }} <!-- Pagination -->
        </div>
    </div>
</div>

<!-- Inclure Chart.js pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des visites par page
    const pageVisitsCtx = document.getElementById('pageVisitsChart').getContext('2d');
    new Chart(pageVisitsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($pageVisitsLabels) !!},
            datasets: [{
                label: 'Visites',
                data: {!! json_encode($pageVisitsData) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique des actions des utilisateurs
    const userActionsCtx = document.getElementById('userActionsChart').getContext('2d');
    new Chart(userActionsCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($userActionsLabels) !!},
            datasets: [{
                label: 'Actions',
                data: {!! json_encode($userActionsData) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
</script>
@endsection