<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Negotiation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NegotiationController extends Controller
{
    public function store(Request $request, Devis $devis)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // Vérifier si le devis est en attente
        if ($devis->Statut !== 'En attente') {
            return back()->with('error', 'La négociation n\'est possible que pour les devis en attente.');
        }

        // Vérifier si l'utilisateur est autorisé
        if (Auth::user()->Role === 'client' && $devis->ClientID !== Auth::id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à négocier ce devis.');
        }

        // Créer la négociation
        $negotiation = new Negotiation([
            'message' => $request->message,
            'sender_type' => Auth::user()->Role === 'client' ? 'client' : 'admin',
            'sender_id' => Auth::id()
        ]);

        $devis->negotiations()->save($negotiation);

        return back()->with('success', 'Message envoyé avec succès.');
    }
} 