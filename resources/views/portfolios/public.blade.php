@extends('layouts.guest')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Nos Portfolios</h1>
        <div class="row">
            @foreach ($portfolios as $portfolio)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if ($portfolio->ImageURL)
                            <img src="{{ $portfolio->ImageURL }}" class="card-img-top" alt="{{ $portfolio->Title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $portfolio->Title }}</h5>
                            <p class="card-text">{{ Str::limit($portfolio->Description, 100) }}</p>
                            <p class="card-text"><strong>Catégorie :</strong> {{ $portfolio->Category }}</p>
                            @if ($portfolio->LiveLink)
                                <a href="{{ $portfolio->LiveLink }}" class="btn btn-primary" target="_blank">Voir en direct</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection