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
        $user = auth()->user();
    
        // Récupérer les projets avec :
        // - ApprovalStatus = "Approved" (acceptés par l'admin)
        // - Status = "Pending" (statut en attente)
        // - ClientID = ID de l'utilisateur connecté (projets appartenant à l'utilisateur)
        $projects = Project::where('ApprovalStatus', 'Approved')
            ->where('Status', 'Pending')
            ->where('ClientID', $user->UserID)
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
    
        // Récupérer la liste des projets et clients pour le formulaire
        $projects = Project::all();
        $clients = User::where('Role', 'Client')->get();
    
        // Passer les données à la vue
        return view('devis.edit', compact('devis', 'projects', 'clients'));
    }
    
    public function update(Request $request, Devis $devis)
    {
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

        // Enregistrer la signature
        $devis->update([
            'signature' => $request->input('signature'), // Stocker la signature en base64
        ]);

        // Gérer l'action
        $action = $request->input('action');
        if ($action === 'accept') {
            $devis->update(['Statut' => 'Accepté']);
            $message = 'Devis accepté avec succès.';
        } elseif ($action === 'reject') {
            $devis->update(['Statut' => 'Refusé']);
            $message = 'Devis refusé avec succès.';
        }

        // Rediriger avec un message de succès
        return redirect()->route('client.devis.show', $devis)
            ->with('success', $message);
    }
}