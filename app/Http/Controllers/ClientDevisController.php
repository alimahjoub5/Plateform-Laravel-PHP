<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientDevisController extends Controller
{

    public function download(Devis $devis)
    {
        // Vérifier que le devis appartient bien au client connecté
        if ($devis->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }
    
        // Récupérer les informations de l'entreprise
        $contactInfo = ContactInfo::first(); // Supposons qu'il n'y a qu'une seule entrée dans la table ContactInfo
    
        // Passer les données à la vue PDF
        $pdf = Pdf::loadView('client.devis.pdf', [
            'devis' => $devis,
            'contactInfo' => $contactInfo,
        ]);
    
        // Télécharger le PDF
        return $pdf->download('devis-' . $devis->Reference . '.pdf');
    }
    // Afficher la liste des devis du client
    public function index()
    {
        // Récupérer les devis associés au client connecté
        $devis = Devis::where('ClientID', auth()->id())->get();
        return view('client.devis.index', compact('devis'));
    }

    // Afficher les détails d'un devis spécifique
    public function show(Devis $devis)
    {
        // Vérifier que le devis appartient bien au client connecté
        if ($devis->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }
        $contactInfo = ContactInfo::first(); // Supposons qu'il n'y a qu'une seule entrée dans la table ContactInfo


        return view('client.devis.show', compact('devis','contactInfo'));
    }

    // Accepter un devis
    public function accept(Devis $devis)
    {
        if ($devis->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Mettre à jour le statut du devis
        $devis->update(['Statut' => 'Accepté']);

        return redirect()->route('client.devis.show', $devis)->with('success', 'Devis accepté avec succès.');
    }

    // Refuser un devis
    public function reject(Devis $devis)
    {
        if ($devis->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Mettre à jour le statut du devis
        $devis->update(['Statut' => 'Refusé']);

        return redirect()->route('client.devis.show', $devis)->with('success', 'Devis refusé avec succès.');
    }

    // Demander des modifications
    public function requestChanges(Request $request, Devis $devis)
    {
        if ($devis->ClientID !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        // Valider la demande de modifications
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Mettre à jour le statut et enregistrer le commentaire
        $devis->update([
            'Statut' => 'Modifications demandées',
            'CommentaireClient' => $request->comment,
        ]);

        return redirect()->route('client.devis.show', $devis)->with('success', 'Demande de modifications envoyée avec succès.');
    }
}
