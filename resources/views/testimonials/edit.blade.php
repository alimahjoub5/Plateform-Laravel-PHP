@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le témoignage</h1>
    <form action="{{ route('testimonials.update', $testimonial->TestimonialID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ClientID">Client</label>
            <select name="ClientID" id="ClientID" class="form-control">
                @foreach ($clients as $client)
                <option value="{{ $client->UserID }}" {{ $testimonial->ClientID == $client->UserID ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="ProjectID">Projet</label>
            <select name="ProjectID" id="ProjectID" class="form-control">
                @foreach ($projects as $project)
                <option value="{{ $project->ProjectID }}" {{ $testimonial->ProjectID == $project->ProjectID ? 'selected' : '' }}>{{ $project->Title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="Feedback">Feedback</label>
            <textarea name="Feedback" id="Feedback" class="form-control" rows="3">{{ $testimonial->Feedback }}</textarea>
        </div>
        <div class="form-group">
            <label for="Rating">Rating</label>
            <input type="number" name="Rating" id="Rating" class="form-control" min="1" max="5" value="{{ $testimonial->Rating }}">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection