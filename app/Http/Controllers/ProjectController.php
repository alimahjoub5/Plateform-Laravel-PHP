<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Afficher la liste des projets
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    // Afficher le formulaire de création d'un projet
    public function create()
    {
        $clients = User::where('role', 'client')->get(); // Supposons que les clients ont un rôle 'client'
        return view('projects.create', compact('clients'));
    }

    // Enregistrer un nouveau projet
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'ClientID' => 'required|exists:users,UserID',
            'Budget' => 'required|numeric',
            'Deadline' => 'required|date',
            'Status' => 'required|string',
            'ApprovalStatus' => 'required|string|in:Pending,Approved,Rejected',
        ]);

        // Créer le projet
        $project = Project::create($validatedData);

        // Envoyer une notification à l'Administrateur
        $Admin = User::where('role', 'Admin')->first(); // Trouver l'Administrateur
        if ($Admin) {
            Notification::create([
                'UserID' => $Admin->UserID,
                'Message' => 'Un nouveau projet "' . $project->Title . '" a été créé par le client.',
            ]);
        }

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }

    // Afficher les détails d'un projet
    public function show($id)
    {
        $project = Project::with(['client', 'devis'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    // Afficher le formulaire de modification d'un projet
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $clients = User::where('role', 'client')->get();
        return view('projects.edit', compact('project', 'clients'));
    }

    // Mettre à jour un projet existant
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validatedData = $request->validate([
            'Title' => 'sometimes|string|max:255',
            'Description' => 'sometimes|string',
            'ClientID' => 'sometimes|exists:users,UserID',
            'Budget' => 'sometimes|numeric',
            'Deadline' => 'sometimes|date',
            'Status' => 'sometimes|string',
            'ApprovalStatus' => 'sometimes|string|in:Pending,Approved,Rejected',
        ]);

        $project->update($validatedData);

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $project->ClientID,
            'Message' => 'Le projet "' . $project->Title . '" a été mis à jour par l\'Administrateur.',
        ]);

        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès.');
    }

    // Supprimer un projet
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $project->ClientID,
            'Message' => 'Le projet "' . $project->Title . '" a été supprimé par l\'Administrateur.',
        ]);

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès.');
    }

    // Affecter un projet à un utilisateur
    public function assignProject(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);

        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);

        // Affecter le projet à l'utilisateur
        $project->ClientID = $userId;
        $project->save();

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $userId,
            'Message' => 'Le projet "' . $project->Title . '" vous a été affecté par l\'Administrateur.',
        ]);

        return redirect()->route('projects.show', $projectId)->with('success', 'Projet affecté avec succès.');
    }

    // Accepter un projet
    public function approveProject($id)
    {
        $project = Project::findOrFail($id);
        $project->approve();

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $project->ClientID,
            'Message' => 'Le projet "' . $project->Title . '" a été approuvé par l\'Administrateur.',
        ]);

        return redirect()->route('projects.show', $id)->with('success', 'Projet approuvé avec succès.');
    }

    // Refuser un projet
    public function rejectProject($id)
    {
        $project = Project::findOrFail($id);
        $project->reject();

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $project->ClientID,
            'Message' => 'Le projet "' . $project->Title . '" a été refusé par l\'Administrateur.',
        ]);

        return redirect()->route('projects.show', $id)->with('success', 'Projet refusé avec succès.');
    }

    // Afficher le formulaire de demande de projet pour le client
    public function requestForm()
    {
        return view('client.request');
    }

    // Traiter la soumission du formulaire de demande de projet
    public function submitRequest(Request $request)
    {
        $validatedData = $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'Budget' => 'required|numeric',
            'Deadline' => 'required|date',
        ]);

        // Ajouter des valeurs par défaut
        $validatedData['ClientID'] = auth()->user()->UserID; // ID du client connecté
        $validatedData['Status'] = 'Pending'; // Statut par défaut
        $validatedData['ApprovalStatus'] = 'Pending'; // Statut d'approbation par défaut

        // Créer le projet
        $project = Project::create($validatedData);

        // Envoyer une notification à l'Administrateur
        $Admin = User::where('role', 'Admin')->first(); // Trouver l'Administrateur
        if ($Admin) {
            Notification::create([
                'UserID' => $Admin->UserID,
                'Message' => 'Un nouveau projet "' . $project->Title . '" a été soumis par le client.',
            ]);
        }

        return redirect()->route('client.request')->with('success', 'Votre demande de projet a été soumise avec succès.');
    }

    // Afficher les services demandés par le client
    public function clientServices()
    {
        // Récupérer l'ID du client connecté
        $clientId = auth()->user()->UserID;

        // Récupérer les projets demandés par ce client
        $projects = Project::where('ClientID', $clientId)->get();

        // Grouper les projets par statut et approbation
        $groupedProjects = [
            'pending' => $projects->where('Status', 'Pending')->where('ApprovalStatus', 'Pending'),
            'approved' => $projects->where('ApprovalStatus', 'Approved'),
            'rejected' => $projects->where('ApprovalStatus', 'Rejected'),
            'in_progress' => $projects->where('Status', 'In Progress'),
            'completed' => $projects->where('Status', 'Completed'),
            'cancelled' => $projects->where('Status', 'Cancelled'),
        ];

        // Passer les projets groupés à la vue
        return view('client.services', compact('groupedProjects'));
    }

    // Annuler un projet
    public function cancelProject($id)
    {
        $project = Project::findOrFail($id);

        // Vérifier que le projet appartient au client connecté
        if ($project->ClientID !== auth()->user()->UserID) {
            return redirect()->route('client.services')->with('error', 'Vous n\'êtes pas autorisé à annuler ce projet.');
        }

        // Vérifier que le projet peut être annulé
        if ($project->Status === 'Cancelled' || $project->Status === 'Completed') {
            return redirect()->route('client.services')->with('error', 'Ce projet ne peut pas être annulé.');
        }

        // Mettre à jour le statut du projet
        $project->update(['Status' => 'Cancelled']);

        // Envoyer une notification à l'Administrateur
        $Admin = User::where('role', 'Admin')->first(); // Trouver l'Administrateur
        if ($Admin) {
            Notification::create([
                'UserID' => $Admin->UserID,
                'Message' => 'Le projet "' . $project->Title . '" a été annulé par le client.',
            ]);
        }

        return redirect()->route('client.services')->with('success', 'Le projet a été annulé avec succès.');
    }

    public function showAssignForm($id)
    {
        $project = Project::findOrFail($id);
        $freelancers = User::where('Role', 'freelancer')->get();
        
        return view('projects.assign', compact('project', 'freelancers'));
    }

    public function assignFreelancers(Request $request, $id)
    {
        $request->validate([
            'freelancers' => 'array',
            'freelancers.*' => 'exists:users,UserID,Role,freelancer'
        ]);

        $project = Project::findOrFail($id);
        
        // Vérifier que tous les IDs sont bien des freelancers
        $freelancerIds = User::whereIn('UserID', $request->freelancers ?? [])
                            ->where('Role', 'freelancer')
                            ->pluck('UserID')
                            ->toArray();

        // Mettre à jour le statut du projet à "In Progress"
        $project->update(['Status' => 'In Progress']);

        // Synchroniser les freelancers
        $project->freelancers()->sync($freelancerIds);

        // Envoyer une notification aux freelancers affectés
        foreach ($freelancerIds as $freelancerId) {
            Notification::create([
                'UserID' => $freelancerId,
                'Message' => 'Vous avez été affecté au projet "' . $project->Title . '".'
            ]);
        }

        return redirect()->route('projects.show', $id)
                        ->with('success', 'Les freelancers ont été affectés avec succès et le projet est maintenant en cours.');
    }
}