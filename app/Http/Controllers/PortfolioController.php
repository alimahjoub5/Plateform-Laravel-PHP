<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Project;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::all();
        return view('portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer uniquement les projets terminés
        $projects = Project::where('Status', 'Completed')->get();
    
        // Liste des tags disponibles (vous pouvez les récupérer depuis la base de données)
        $tags = ['Design', 'Web Development', 'Mobile App', 'UI/UX', 'SEO', 'E-commerce', 'Laravel', 'Vue.js', 'React', 'JavaScript'];
    
        return view('portfolios.create', compact('projects', 'tags'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'ProjectID' => 'required|exists:projects,ProjectID',
        'Title' => 'required|string|max:255',
        'Description' => 'required|string',
        'ImageURL' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'LiveLink' => 'nullable|string|max:500',
        'Category' => 'required|in:Web Development,Mobile App,Design,Other',
        'Tags' => 'nullable|array', // Valider que Tags est un tableau
        'Tags.*' => 'string|max:255', // Valider chaque élément du tableau
    ]);

    // Convertir le tableau de tags en JSON
    $tags = json_encode($request->Tags);

    // Gérer l'upload de l'image
    if ($request->hasFile('ImageURL')) {
        $imagePath = $request->file('ImageURL')->store('portfolio_images', 'public');
    } else {
        $imagePath = null;
    }

    // Créer le portfolio
    $portfolio = Portfolio::create([
        'ProjectID' => $request->ProjectID,
        'Title' => $request->Title,
        'Description' => $request->Description,
        'ImageURL' => $imagePath,
        'LiveLink' => $request->LiveLink,
        'Category' => $request->Category,
        'Tags' => $tags, // Stocker les tags sous forme de JSON
    ]);

    return redirect()->route('portfolios.index')->with('success', 'Portfolio créé avec succès.');
}

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        return view('portfolios.show', compact('portfolio'));
    }

    public function getTags(Request $request)
{
    // Exemple de tags prédéfinis
    $tags = ['Design', 'Web Development', 'Mobile App', 'UI/UX', 'SEO', 'E-commerce', 'Laravel', 'Vue.js', 'React', 'JavaScript'];
    // Si vous avez des tags dans la base de données, vous pouvez les récupérer comme ceci :
    // $tags = Portfolio::pluck('Tags')->flatten()->unique()->toArray();

    return response()->json($tags);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'ImageURL' => 'nullable|string|max:500',
            'LiveLink' => 'nullable|string|max:500',
            'Category' => 'required|in:Web Development,Mobile App,Design,Other',
            'Tags' => 'nullable|json',
        ]);

        $portfolio->update($request->all());

        return redirect()->route('portfolios.index')->with('success', 'Portfolio updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portfolio deleted successfully.');
    }

    public function affiche(Request $request)
    {
        $query = Portfolio::query();
    
        if ($request->has('search') && $request->search != '') {
            $query->where('Title', 'like', '%' . $request->search . '%')
                  ->orWhere('Description', 'like', '%' . $request->search . '%');
        }
    
        $portfolios = $query->paginate(6);
        return view('portfolios.public', compact('portfolios'));
    }
}