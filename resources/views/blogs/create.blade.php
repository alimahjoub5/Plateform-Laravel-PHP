@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un nouveau blog</h1>
    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="Title">Titre</label>
            <input type="text" name="Title" id="Title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Content">Contenu</label>
            <textarea name="Content" id="Content" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="Category">Catégorie</label>
            <select name="Category" id="Category" class="form-control" required>
                <option value="Tutorial">Tutoriel</option>
                <option value="Case Study">Étude de cas</option>
                <option value="News">Actualités</option>
                <option value="Other">Autre</option>
            </select>
        </div>
        <div class="form-group">
            <label for="FeaturedImage">Image mise en avant</label>
            <input type="file" name="FeaturedImage" id="FeaturedImage" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>

<!-- Ajouter CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('Content', {
        height: 400,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
            { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize', 'Source'] }
        ],
        removeButtons: 'Subscript,Superscript',
        language: 'fr',
    });
</script>
@endsection