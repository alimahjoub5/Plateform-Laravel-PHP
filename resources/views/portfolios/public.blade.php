@extends('layouts.guest')

@section('content')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Nos Portfolios</h1>

        <!-- Filtre par catégorie -->
        <div class="mb-4">
            <form action="{{ route('portfolios.public') }}" method="GET">
                <label for="category" class="form-label">Filtrer par catégorie :</label>
                <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    <option value="Web Development" {{ request('category') == 'Web Development' ? 'selected' : '' }}>Développement Web</option>
                    <option value="Mobile App" {{ request('category') == 'Mobile App' ? 'selected' : '' }}>Application Mobile</option>
                    <option value="Design" {{ request('category') == 'Design' ? 'selected' : '' }}>Design</option>
                    <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Autre</option>
                </select>
            </form>
        </div>

        <!-- Recherche -->
        <div class="mb-4">
            <form action="{{ route('portfolios.public') }}" method="GET">
                <label for="search" class="form-label">Rechercher :</label>
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Entrez un titre ou une description..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
        </div>

        <!-- Liste des portfolios -->
        <div class="row">
            @foreach ($portfolios as $portfolio)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if ($portfolio->ImageURL)
                        <img src="{{ asset('storage/' .  $portfolio->ImageURL) }}" alt="{{ $portfolio->Title }}" class="w-full h-48 object-cover">                        @else    
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $portfolio->Title }}</h5>
                            <p class="card-text">{{ Str::limit($portfolio->Description, 100) }}</p>
                            <p class="card-text"><strong>Catégorie :</strong> {{ $portfolio->Category }}</p>
                            @if ($portfolio->LiveLink)
                                <a href="{{ $portfolio->LiveLink }}" class="btn btn-primary" target="_blank">Voir en direct</a>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            @if ($portfolio->Tags)
                                @foreach (json_decode($portfolio->Tags, true) as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                @endforeach
                            @endif
                            <small class="text-muted">Ajouté le {{ $portfolio->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $portfolios->links() }}
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection