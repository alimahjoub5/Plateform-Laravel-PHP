@extends('layouts.app')

@section('content')
    <h1>{{ $portfolio->Title }}</h1>
    <p>{{ $portfolio->Description }}</p>
    <p><strong>Category:</strong> {{ $portfolio->Category }}</p>
    <p><strong>Image URL:</strong> {{ $portfolio->ImageURL }}</p>
    <p><strong>Live Link:</strong> {{ $portfolio->LiveLink }}</p>
    <p><strong>Tags:</strong> {{ $portfolio->Tags }}</p>
    <a href="{{ route('portfolios.edit', $portfolio->PortfolioID) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('portfolios.destroy', $portfolio->PortfolioID) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endsection