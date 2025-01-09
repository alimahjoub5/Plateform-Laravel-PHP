@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un Service</h1>
    <form action="{{ route('services.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ServiceName">Nom du Service</label>
            <input type="text" name="ServiceName" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="Description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="Price">Prix</label>
            <input type="number" step="0.01" name="Price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Category">Catégorie</label>
            <select name="Category" class="form-control" required>
                <option value="Development">Développement</option>
                <option value="Design">Design</option>
                <option value="Consulting">Consulting</option>
                <option value="Other">Autre</option>
            </select>
        </div>
        <div class="form-group">
            <label for="IsAvailable">Disponible</label>
            <input type="checkbox" name="IsAvailable" value="1" checked>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection