@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Services</h1>
    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Créer un Service</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Catégorie</th>
                <th>Disponible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>{{ $service->ServiceName }}</td>
                    <td>{{ $service->Description }}</td>
                    <td>{{ $service->Price }}</td>
                    <td>{{ $service->Category }}</td>
                    <td>{{ $service->IsAvailable ? 'Oui' : 'Non' }}</td>
                    <td>
                        <a href="{{ route('services.show', $service->ServiceID) }}" class="btn btn-info">Voir</a>
                        <a href="{{ route('services.edit', $service->ServiceID) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('services.destroy', $service->ServiceID) }}" method="POST" style="display:inline;">
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