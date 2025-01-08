@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <h1 class="display-5 fw-bold mb-4">Détails de la notification</h1>

                        <div class="mb-3">
                            <p><strong>Message :</strong> {{ $notification->Message }}</p>
                            <p><strong>Date :</strong> {{ $notification->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Statut :</strong> {{ $notification->IsRead ? 'Lue' : 'Non lue' }}</p>
                        </div>

                        <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection