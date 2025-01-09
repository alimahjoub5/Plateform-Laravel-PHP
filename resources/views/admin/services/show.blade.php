@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Service</h1>
    <p><strong>Nom :</strong> {{ $service->ServiceName }}</p>
    <p><strong>Description :</strong> {{ $service->Description }}</p>
    <p><strong>Prix :</strong> {{ $service->Price }}</p>
    <p><strong>Catégorie :</strong> {{ $service->Category }}</p>
    <p><strong>Disponible :</strong> {{ $service->IsAvailable ? 'Oui' : 'Non' }}</p>
    <a href="{{ route('services.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection