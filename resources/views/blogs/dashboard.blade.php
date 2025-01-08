@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de bord des blogs</h1>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Créer un nouveau blog</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->Title }}</td>
                        <td>{{ $blog->Category }}</td>
                        <td>{{ $blog->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('blogs.edit', $blog->BlogID) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('blogs.destroy', $blog->BlogID) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce blog ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection