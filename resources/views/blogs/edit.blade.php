@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le blog</h1>
    <form action="{{ route('blogs.update', $blog->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="Title">Titre</label>
            <input type="text" name="Title" id="Title" class="form-control" value="{{ $blog->Title }}" required>
        </div>
        <div class="form-group">
            <label for="Content">Contenu</label>
            <textarea name="Content" id="Content" class="form-control" rows="5" required>{{ $blog->Content }}</textarea>
        </div>
        <div class="form-group">
            <label for="Category">Catégorie</label>
            <select name="Category" id="Category" class="form-control" required>
                <option value="Tutorial" {{ $blog->Category == 'Tutorial' ? 'selected' : '' }}>Tutoriel</option>
                <option value="Case Study" {{ $blog->Category == 'Case Study' ? 'selected' : '' }}>Étude de cas</option>
                <option value="News" {{ $blog->Category == 'News' ? 'selected' : '' }}>Actualités</option>
                <option value="Other" {{ $blog->Category == 'Other' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>
        <div class="form-group">
            <label for="FeaturedImage">Image mise en avant (URL)</label>
            <input type="text" name="FeaturedImage" id="FeaturedImage" class="form-control" value="{{ $blog->FeaturedImage }}">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection