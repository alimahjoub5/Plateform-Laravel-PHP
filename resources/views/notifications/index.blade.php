@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <h1 class="display-5 fw-bold mb-4">Mes notifications</h1>

                        @if ($notifications->isEmpty())
                            <div class="alert alert-info">
                                Vous n'avez aucune notification.
                            </div>
                        @else
                            <div class="list-group">
                                @foreach ($notifications as $notification)
                                    <div class="list-group-item {{ $notification->IsRead ? 'bg-light' : 'bg-white' }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1">{{ $notification->Message }}</p>
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div>
                                                @if (!$notification->IsRead)
                                                    <form action="{{ route('notifications.markAsRead', $notification->NotificationID) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Marquer comme lue
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('notifications.destroy', $notification->NotificationID) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection