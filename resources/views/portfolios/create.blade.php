@extends('layouts.app')

@section('content')
    <h1>Create New Portfolio</h1>
    <form action="{{ route('portfolios.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ProjectID">Project ID</label>
            <input type="number" name="ProjectID" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Title">Title</label>
            <input type="text" name="Title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="Description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="ImageURL">Image URL</label>
            <input type="text" name="ImageURL" class="form-control">
        </div>
        <div class="form-group">
            <label for="LiveLink">Live Link</label>
            <input type="text" name="LiveLink" class="form-control">
        </div>
        <div class="form-group">
            <label for="Category">Category</label>
            <select name="Category" class="form-control" required>
                <option value="Web Development">Web Development</option>
                <option value="Mobile App">Mobile App</option>
                <option value="Design">Design</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Tags">Tags</label>
            <input type="text" name="Tags" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection