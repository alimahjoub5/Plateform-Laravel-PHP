@extends('layouts.app')

@section('content')
    <h1>Edit Portfolio</h1>
    <form action="{{ route('portfolios.update', $portfolio->PortfolioID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ProjectID">Project ID</label>
            <input type="number" name="ProjectID" class="form-control" value="{{ $portfolio->ProjectID }}" required>
        </div>
        <div class="form-group">
            <label for="Title">Title</label>
            <input type="text" name="Title" class="form-control" value="{{ $portfolio->Title }}" required>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="Description" class="form-control" required>{{ $portfolio->Description }}</textarea>
        </div>
        <div class="form-group">
            <label for="ImageURL">Image URL</label>
            <input type="text" name="ImageURL" class="form-control" value="{{ $portfolio->ImageURL }}">
        </div>
        <div class="form-group">
            <label for="LiveLink">Live Link</label>
            <input type="text" name="LiveLink" class="form-control" value="{{ $portfolio->LiveLink }}">
        </div>
        <div class="form-group">
            <label for="Category">Category</label>
            <select name="Category" class="form-control" required>
                <option value="Web Development" {{ $portfolio->Category == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                <option value="Mobile App" {{ $portfolio->Category == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                <option value="Design" {{ $portfolio->Category == 'Design' ? 'selected' : '' }}>Design</option>
                <option value="Other" {{ $portfolio->Category == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Tags">Tags</label>
            <input type="text" name="Tags" class="form-control" value="{{ $portfolio->Tags }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection