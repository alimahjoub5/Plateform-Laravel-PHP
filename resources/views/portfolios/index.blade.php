@extends('layouts.app')

@section('content')
    <h1>Portfolios</h1>
    <a href="{{ route('portfolios.create') }}" class="btn btn-success">Create New Portfolio</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($portfolios as $portfolio)
                <tr>
                    <td>{{ $portfolio->PortfolioID }}</td>
                    <td>{{ $portfolio->Title }}</td>
                    <td>{{ $portfolio->Category }}</td>
                    <td>
                        <a href="{{ route('portfolios.show', $portfolio->PortfolioID) }}" class="btn btn-info">View</a>
                        <a href="{{ route('portfolios.edit', $portfolio->PortfolioID) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('portfolios.destroy', $portfolio->PortfolioID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection