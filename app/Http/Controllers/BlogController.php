<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\PageVisited;

class BlogController extends Controller
{
    // Afficher la liste des blogs
    public function index()
    {
        // Enregistrer l'événement de visite de page
        event(new PageVisited(request()->path(), Auth::id(), 'view', request()->header('User-Agent')));

        $blogs = Blog::paginate(6); // Pagination avec 6 blogs par page
        return view('blogs.index', compact('blogs'));
    }

    // Afficher le formulaire de création d'un blog
    public function create()
    {
        return view('blogs.create');
    }

    // Afficher le tableau de bord des blogs de l'utilisateur
    public function dashboard()
    {
        // Récupérer les blogs de l'utilisateur connecté
        $blogs = auth()->user()->blogs()->latest()->get();
        return view('blogs.dashboard', compact('blogs'));
    }

    // Enregistrer un nouveau blog
    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|string|max:255',
            'Content' => 'required|string',
            'Category' => 'required|in:Tutorial,Case Study,News,Other',
            'FeaturedImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Accepter uniquement les images
        ]);

        // Gérer l'upload de l'image
        $imagePath = null;
        if ($request->hasFile('FeaturedImage')) {
            $imagePath = $request->file('FeaturedImage')->store('blogs', 'public'); // Stocker l'image dans le dossier "public/blogs"
        }

        Blog::create([
            'Title' => $request->Title,
            'Content' => $request->Content,
            'AuthorID' => Auth::id(),
            'Category' => $request->Category,
            'FeaturedImage' => $imagePath, // Enregistrer le chemin de l'image
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog créé avec succès.');
    }

    // Afficher un blog spécifique
    public function show(Blog $blog)
    {
        // Enregistrer l'événement de visite de page
        event(new PageVisited(request()->path(), Auth::id(), 'view', request()->header('User-Agent')));

        return view('blogs.show', compact('blog'));
    }

    // Afficher le formulaire d'édition d'un blog
    public function edit(Blog $blog)
    {
        // Vérifier que l'utilisateur est bien l'auteur du blog
        if (auth()->id() !== $blog->AuthorID) {
            abort(403, 'Accès non autorisé.');
        }

        return view('blogs.edit', compact('blog'));
    }

    // Mettre à jour un blog existant
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'Title' => 'required|string|max:255',
            'Content' => 'required|string',
            'Category' => 'required|in:Tutorial,Case Study,News,Other',
            'FeaturedImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('FeaturedImage')) {
            // Supprimer l'ancienne image si elle existe
            if ($blog->FeaturedImage) {
                Storage::disk('public')->delete($blog->FeaturedImage);
            }
            // Stocker la nouvelle image
            $imagePath = $request->file('FeaturedImage')->store('blogs', 'public');
            $blog->FeaturedImage = $imagePath;
        }

        $blog->update([
            'Title' => $request->Title,
            'Content' => $request->Content,
            'Category' => $request->Category,
            'FeaturedImage' => $blog->FeaturedImage, // Mettre à jour le chemin de l'image
        ]);

        return redirect()->route('blogs.dashboard')->with('success', 'Blog mis à jour avec succès.');
    }

    // Supprimer un blog
    public function destroy($blogID)
    {
        // Récupérer le blog par son ID
        $blog = Blog::findOrFail($blogID);

        // Vérifier que l'utilisateur est bien l'auteur du blog
        if (auth()->id() !== $blog->AuthorID) {
            abort(403, 'Accès non autorisé.');
        }

        // Supprimer l'image associée si elle existe
        if ($blog->FeaturedImage) {
            Storage::disk('public')->delete($blog->FeaturedImage);
        }

        // Supprimer le blog
        $blog->delete();

        return redirect()->route('blogs.dashboard')->with('success', 'Blog supprimé avec succès.');
    }
}