<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with(['project'])
            ->where('ClientID', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $projects = Project::where('ClientID', auth()->id())
            ->where('Status', 'Completed')
            ->whereDoesntHave('testimonial')
            ->get();

        \Log::info('Testimonials data:', ['testimonials' => $testimonials->toArray()]);
        \Log::info('Projects data:', ['projects' => $projects->toArray()]);

        return view('client.testimonials.index', compact('testimonials', 'projects'));
    }

    public function create()
    {
        $projects = Project::where('ClientID', auth()->id())
            ->where('Status', 'Completed')
            ->whereDoesntHave('testimonial')
            ->get();

        return view('client.testimonials.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,ProjectID',
            'content' => 'required|min:10',
            'rating' => 'required|integer|between:1,5'
        ]);

        // Vérifier que le projet appartient au client
        $project = Project::where('ProjectID', $request->project_id)
            ->where('ClientID', auth()->id())
            ->firstOrFail();

        // Vérifier qu'il n'y a pas déjà un témoignage pour ce projet
        if ($project->testimonial) {
            return redirect()->back()->with('error', 'Un témoignage existe déjà pour ce projet.');
        }

        Testimonial::create([
            'ClientID' => auth()->id(),
            'ProjectID' => $request->project_id,
            'Content' => $request->content,
            'Rating' => $request->rating,
            'Status' => 'Pending'
        ]);

        return redirect()->back()->with('success', 'Témoignage soumis avec succès. Il sera visible après approbation.');
    }

    public function show(Testimonial $testimonial)
    {
        // Vérifier que le témoignage appartient au client
        if ($testimonial->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('client.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        // Vérifier que le témoignage appartient au client
        if ($testimonial->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifier que le témoignage n'est pas déjà approuvé
        if ($testimonial->Status === 'Approved') {
            return redirect()->route('client.testimonials.index')
                ->with('error', 'Les témoignages approuvés ne peuvent pas être modifiés.');
        }

        return view('client.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        // Vérifier que le témoignage appartient au client
        if ($testimonial->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifier que le témoignage n'est pas déjà approuvé
        if ($testimonial->Status === 'Approved') {
            return redirect()->route('client.testimonials.index')
                ->with('error', 'Les témoignages approuvés ne peuvent pas être modifiés.');
        }

        $request->validate([
            'content' => 'required|min:10',
            'rating' => 'required|integer|between:1,5'
        ]);

        $testimonial->update([
            'Content' => $request->content,
            'Rating' => $request->rating,
            'Status' => 'Pending' // Réinitialiser le statut car le témoignage doit être réapprouvé
        ]);

        return redirect()->route('client.testimonials.index')
            ->with('success', 'Témoignage mis à jour avec succès. Il sera visible après réapprobation.');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Vérifier que le témoignage appartient au client
        if ($testimonial->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Vérifier que le témoignage n'est pas déjà approuvé
        if ($testimonial->Status === 'Approved') {
            return redirect()->route('client.testimonials.index')
                ->with('error', 'Les témoignages approuvés ne peuvent pas être supprimés.');
        }

        $testimonial->delete();

        return redirect()->route('client.testimonials.index')
            ->with('success', 'Témoignage supprimé avec succès.');
    }
} 