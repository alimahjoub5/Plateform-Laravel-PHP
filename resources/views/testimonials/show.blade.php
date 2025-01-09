@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Témoignage</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Client: {{ $testimonial->client->name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Projet: {{ $testimonial->project->Title }}</h6>
            <p class="card-text">{{ $testimonial->Feedback }}</p>
            <p class="card-text">Rating: {{ $testimonial->Rating }}</p>
            <a href="{{ route('testimonials.edit', $testimonial->TestimonialID) }}" class="btn btn-warning">Modifier</a>
            <form action="{{ route('testimonials.destroy', $testimonial->TestimonialID) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection