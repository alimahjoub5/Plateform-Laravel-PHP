<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ContactInfo;

class DevisController extends Controller
{
    /**
     * Affiche la liste des devis.
     */
    public function index()
    {
        // Récupérer tous les devis avec leurs relations
        $devis = Devis::with(['project', 'client'])->get();

        // Vue : resources/views/devis/index.blade.php
        return view('devis.index', compact('devis'));
    }

    /**
     * Affiche le formulaire de création d'un devis.
     */
    public function create()
    {
        // Récupérer l'utilisateur connecté
            $projects = Project::where('ApprovalStatus', 'Approved')
            ->where('Status', 'Pending')
            ->get();
    
        // Générer une référence unique
        $reference = 'DEV-' . strtoupper(uniqid());
    
        // Passer les projets et la référence à la vue
        return view('devis.create', compact('projects', 'reference'));
    }

    /**
     * Enregistre un nouveau devis dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'ClientID' => 'required|exists:users,UserID',
            'Reference' => 'required|string|unique:devis,Reference',
            'DateEmission' => 'required|date',
            'DateValidite' => 'required|date',
            'TotalHT' => 'required|numeric',
            'TVA' => 'required|numeric',
            'TotalTTC' => 'required|numeric',
            'ConditionsGenerales' => 'nullable|string',
        ]);
    
        // Ajouter l'utilisateur connecté comme créateur du devis
        $request->merge(['CreatedBy' => auth()->id()]);
    
        // Création du devis
        Devis::create($request->all());
    
        // Redirection vers la liste des devis avec un message de succès
        return redirect()->route('devis.index')->with('success', 'Devis créé avec succès.');
    }

    /**
     * Affiche les détails d'un devis.
     */

    public function show($id)
    {
        // Récupérer le devis par son ID avec les relations
        $devis = Devis::with(['client', 'project', 'createdBy'])->findOrFail($id);
    
        // Récupérer les informations de contact
        $contactInfo = ContactInfo::first(); // Supposons qu'il n'y a qu'une seule entrée dans la table
    
        // Passer les données à la vue
        return view('devis.show', compact('devis', 'contactInfo'));
    }

    /**
     * Affiche le formulaire de modification d'un devis.
     */
    public function edit($id)
    {
        // Récupérer le devis par son ID avec les relations
        $devis = Devis::with(['client', 'project', 'createdBy'])->findOrFail($id);
    
        // Bloquer les modifications si le devis est signé ou si le statut n'est plus "En attente"
        if ($devis->signature || $devis->Statut !== 'En attente') {
            return redirect()->route('devis.index')
                ->with('error', 'Ce devis ne peut plus être modifié car il a été signé ou son statut a changé.');
        }
    
        // Récupérer la liste des projets et clients pour le formulaire
        $projects = Project::all();
        $clients = User::where('Role', 'Client')->get();
    
        // Passer les données à la vue
        return view('devis.edit', compact('devis', 'projects', 'clients'));
    }
    
    public function update(Request $request, Devis $devis)
    {
        // Bloquer les modifications si le devis est signé ou si le statut n'est plus "En attente"
        if ($devis->signature || $devis->Statut !== 'En attente') {
            return redirect()->route('devis.index')
                ->with('error', 'Ce devis ne peut plus être modifié car il a été signé ou son statut a changé.');
        }
    
        // Validation des données du formulaire
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'ClientID' => 'required|exists:users,UserID',
            'Reference' => 'required|string|unique:devis,Reference,' . $devis->DevisID . ',DevisID',
            'DateEmission' => 'required|date',
            'DateValidite' => 'required|date',
            'TotalHT' => 'required|numeric',
            'TVA' => 'required|numeric',
            'TotalTTC' => 'required|numeric',
            'ConditionsGenerales' => 'nullable|string',
        ]);
    
        // Mise à jour du devis
        $devis->update($request->all());
    
        // Redirection vers la liste des devis avec un message de succès
        return redirect()->route('devis.index')->with('success', 'Devis mis à jour avec succès.');
    }

    /**
     * Supprime un devis de la base de données.
     */
    public function destroy(Devis $devis)
    {
        // Bloquer la suppression si le devis est signé ou si le statut n'est plus "En attente"
        if ($devis->signature || $devis->Statut !== 'En attente') {
            return redirect()->route('devis.index')
                ->with('error', 'Ce devis ne peut plus être supprimé car il a été signé ou son statut a changé.');
        }
    
        // Suppression du devis
        $devis->delete();
    
        // Redirection vers la liste des devis avec un message de succès
        return redirect()->route('devis.index')->with('success', 'Devis supprimé avec succès.');
    }

    public function action(Request $request, Devis $devis)
    {
        // Valider la requête
        $request->validate([
            'signature' => 'required|string', // La signature est obligatoire
            'action' => 'required|in:accept,reject', // L'action doit être "accept" ou "reject"
        ]);
    
        // Extraire la partie base64 de la signature (supprimer le préfixe "data:image/png;base64,")
        $signatureData = $request->input('signature');
        $base64Data = explode(',', $signatureData)[1] ?? $signatureData;
    
        // Déterminer le nouveau statut en fonction de l'action
        $action = $request->input('action');
        $nouveauStatut = ($action === 'accept') ? 'Accepté' : 'Refusé';
    
        // Mettre à jour le devis (signature et statut)
        $devis->update([
            'signature' => $base64Data, // Stocker uniquement la partie base64
            'Statut' => $nouveauStatut, // Mettre à jour le statut
        ]);
    
        // Rediriger avec un message de succès
        return redirect()->route('client.devis.show', $devis)
            ->with('success', 'Devis mis à jour avec succès.');
    }
}