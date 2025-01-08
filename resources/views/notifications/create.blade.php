@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 bg-light">
                    <div class="card-body p-5">
                        <h1 class="display-5 fw-bold mb-4">Créer une notification</h1>

                        <form action="{{ route('notifications.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="Message" class="form-label">Message</label>
                                <textarea name="Message" id="Message" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection