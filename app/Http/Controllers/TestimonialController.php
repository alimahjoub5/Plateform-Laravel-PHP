<?php
namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les témoignages avec les relations client et projet
        $testimonials = Testimonial::with(['client', 'project'])->get();

        // Calculer la note moyenne
        $averageRating = $testimonials->avg('Rating');

        // Calculer le pourcentage de clients satisfaits
        $satisfiedClients = $testimonials->filter(function ($testimonial) {
            return $testimonial->Rating >= 4; // Clients avec une note >= 4
        })->count();

        $totalClients = $testimonials->count();
        $satisfactionPercentage = $totalClients > 0 ? ($satisfiedClients / $totalClients) * 100 : 0;

        // Compter les utilisateurs avec le rôle "Client"
        $activeClientsCount = User::where('Role', 'Client')->count();

        // Passer les données à la vue
        return view('testimonials', compact('testimonials', 'averageRating', 'satisfactionPercentage', 'activeClientsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();
    
        // Récupérer les projets terminés
        $projects = Project::where('Status', 'Completed')->get();
    
        // Pré-remplir le projet si un ProjectID est passé en paramètre
        $selectedProject = null;
        if ($request->has('ProjectID')) {
            $selectedProject = Project::find($request->ProjectID);
        }
    
        return view('testimonials.create', compact('user', 'projects', 'selectedProject'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'Feedback' => 'required|string',
            'Rating' => 'required|integer|between:1,5',
        ]);
    
        // Ajouter l'ID de l'utilisateur connecté aux données du formulaire
        $data = $request->all();
        $data['ClientID'] = auth()->user()->UserID;
    
        // Créer le témoignage
        Testimonial::create($data);
    
        return redirect()->route('testimonials.index')->with('success', 'Témoignage créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return view('testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        $clients = User::where('role', 'client')->get();
        $projects = Project::where('Status', 'Completed')->get();
        return view('testimonials.edit', compact('testimonial', 'clients', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'ClientID' => 'required|exists:users,UserID',
            'ProjectID' => 'required|exists:projects,ProjectID',
            'Feedback' => 'required|string',
            'Rating' => 'required|integer|between:1,5',
        ]);

        $testimonial->update($request->all());

        return redirect()->route('testimonials.index')->with('success', 'Témoignage mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Témoignage supprimé avec succès.');
    }
}