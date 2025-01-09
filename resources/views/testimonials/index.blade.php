@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des témoignages</h1>
    <a href="{{ route('testimonials.create') }}" class="btn btn-primary mb-3">Créer un témoignage</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Projet</th>
                <th>Feedback</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($testimonials as $testimonial)
            <tr>
                <td>{{ $testimonial->TestimonialID }}</td>
                <td>{{ $testimonial->client->name }}</td>
                <td>{{ $testimonial->project->Title }}</td>
                <td>{{ $testimonial->Feedback }}</td>
                <td>{{ $testimonial->Rating }}</td>
                <td>
                    <a href="{{ route('testimonials.show', $testimonial->TestimonialID) }}" class="btn btn-info">Voir</a>
                    <a href="{{ route('testimonials.edit', $testimonial->TestimonialID) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('testimonials.destroy', $testimonial->TestimonialID) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection