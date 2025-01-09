@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Service</h1>
    <form action="{{ route('services.update', $service->ServiceID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ServiceName">Nom du Service</label>
            <input type="text" name="ServiceName" class="form-control" value="{{ $service->ServiceName }}" required>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="Description" class="form-control" required>{{ $service->Description }}</textarea>
        </div>
        <div class="form-group">
            <label for="Price">Prix</label>
            <input type="number" step="0.01" name="Price" class="form-control" value="{{ $service->Price }}" required>
        </div>
        <div class="form-group">
            <label for="Category">Catégorie</label>
            <select name="Category" class="form-control" required>
                <option value="Development" {{ $service->Category == 'Development' ? 'selected' : '' }}>Développement</option>
                <option value="Design" {{ $service->Category == 'Design' ? 'selected' : '' }}>Design</option>
                <option value="Consulting" {{ $service->Category == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                <option value="Other" {{ $service->Category == 'Other' ? 'selected' : '' }}>Autre</option>
            </select>
        </div>
        <div class="form-group">
            <label for="IsAvailable">Disponible</label>
            <input type="checkbox" name="IsAvailable" value="1" {{ $service->IsAvailable ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection