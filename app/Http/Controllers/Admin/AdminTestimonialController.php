<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    /**
     * Affiche la liste des témoignages.
     */
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'project'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $pendingCount = Testimonial::where('Status', 'Pending')->count();
        
        return view('admin.testimonials.index', compact('testimonials', 'pendingCount'));
    }

    /**
     * Affiche la liste des témoignages en attente.
     */
    public function pending()
    {
        $testimonials = Testimonial::with(['user', 'project'])
            ->where('Status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.testimonials.pending', compact('testimonials'));
    }

    /**
     * Approuve un témoignage.
     */
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update([
            'Status' => 'Approved',
            'AdminComment' => request('admin_comment', 'Approuvé par l\'administrateur')
        ]);

        return redirect()->back()->with('success', 'Le témoignage a été approuvé avec succès.');
    }

    /**
     * Rejette un témoignage.
     */
    public function reject(Testimonial $testimonial)
    {
        $testimonial->update([
            'Status' => 'Rejected',
            'AdminComment' => request('admin_comment', 'Rejeté par l\'administrateur')
        ]);

        return redirect()->back()->with('success', 'Le témoignage a été rejeté.');
    }

    /**
     * Supprime un témoignage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Le témoignage a été supprimé avec succès.');
    }
} 