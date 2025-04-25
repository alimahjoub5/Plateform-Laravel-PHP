<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\ContactInfo;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
        $client = Auth::user();
        $devis = Devis::where('ClientID', $client->UserID)
            ->with(['project', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.devis.index', compact('devis'));
    }

    // Afficher les détails d'un devis spécifique
    public function show($id)
    {
        $client = Auth::user();
        $devis = Devis::with(['project', 'lignes', 'createdBy'])
            ->where('ClientID', $client->UserID)
            ->findOrFail($id);

        return view('client.devis.show', compact('devis'));
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

    public function create()
    {
        $client = Auth::user();
        $projects = Project::where('ClientID', $client->UserID)
            ->where('Statut', '!=', 'Terminé')
            ->get();

        return view('client.devis.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,ProjectID',
            'reference' => 'required|string|max:50|unique:devis,Reference',
            'date_emission' => 'required|date',
            'date_validite' => 'required|date|after:date_emission',
            'tva' => 'required|numeric|min:0|max:100',
            'lignes' => 'required|array|min:1',
            'lignes.*.description' => 'required|string|max:255',
            'lignes.*.quantite' => 'required|numeric|min:1',
            'lignes.*.prix_unitaire' => 'required|numeric|min:0',
            'conditions_generales' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $client = Auth::user();
            $project = Project::findOrFail($request->project_id);

            // Vérifier que le projet appartient bien au client
            if ($project->ClientID !== $client->UserID) {
                throw new \Exception('Ce projet ne vous appartient pas.');
            }

            // Calculer les totaux
            $totalHT = 0;
            foreach ($request->lignes as $ligne) {
                $totalHT += $ligne['quantite'] * $ligne['prix_unitaire'];
            }
            $totalTVA = $totalHT * ($request->tva / 100);
            $totalTTC = $totalHT + $totalTVA;

            // Créer le devis
            $devis = Devis::create([
                'ProjectID' => $request->project_id,
                'ClientID' => $client->UserID,
                'Reference' => $request->reference,
                'DateEmission' => $request->date_emission,
                'DateValidite' => $request->date_validite,
                'TotalHT' => $totalHT,
                'TVA' => $request->tva,
                'TotalTTC' => $totalTTC,
                'ConditionsGenerales' => $request->conditions_generales,
                'Statut' => 'En attente',
                'CreatedBy' => $client->UserID,
            ]);

            // Créer les lignes du devis
            foreach ($request->lignes as $ligne) {
                $devis->lignes()->create([
                    'Description' => $ligne['description'],
                    'Quantite' => $ligne['quantite'],
                    'PrixUnitaire' => $ligne['prix_unitaire'],
                    'TotalHT' => $ligne['quantite'] * $ligne['prix_unitaire'],
                ]);
            }

            DB::commit();

            return redirect()->route('client.devis.show', $devis->DevisID)
                ->with('success', 'Le devis a été créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function action(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',
            'signature' => 'required_if:action,accept|string',
        ]);

        $client = Auth::user();
        $devis = Devis::where('ClientID', $client->UserID)
            ->where('Statut', 'En attente')
            ->findOrFail($id);

        try {
            DB::beginTransaction();

            if ($request->action === 'accept') {
                $devis->update([
                    'Statut' => 'Accepté',
                    'signature' => $request->signature,
                ]);

                // Mettre à jour le statut du projet
                $devis->project->update([
                    'Statut' => 'En cours',
                ]);

                // Créer une notification pour l'administrateur
                $admin = User::where('Role', 'admin')->first();
                if ($admin) {
                    $admin->notifications()->create([
                        'type' => 'devis_accepted',
                        'data' => [
                            'devis_id' => $devis->DevisID,
                            'client_id' => $client->UserID,
                            'project_id' => $devis->ProjectID,
                        ],
                    ]);
                }
            } else {
                $devis->update([
                    'Statut' => 'Refusé',
                ]);

                // Créer une notification pour l'administrateur
                $admin = User::where('Role', 'admin')->first();
                if ($admin) {
                    $admin->notifications()->create([
                        'type' => 'devis_rejected',
                        'data' => [
                            'devis_id' => $devis->DevisID,
                            'client_id' => $client->UserID,
                            'project_id' => $devis->ProjectID,
                        ],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('client.devis.show', $devis->DevisID)
                ->with('success', 'Le devis a été ' . ($request->action === 'accept' ? 'accepté' : 'refusé') . ' avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
}
