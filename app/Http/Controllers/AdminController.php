<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification;

class AdminController extends Controller
{
    // Afficher la liste des projets pour l'administrateur
    public function index()
    {
        // Récupérer tous les projets
        $projects = Project::all();

        // Passer les projets à la vue
        return view('admin.projects.index', compact('projects'));
    }

    public function show($id)
    {
        // Récupérer le projet par son ID
        $project = Project::findOrFail($id);
    
        // Récupérer la liste des utilisateurs pour l'affectation
        $users = User::all(); // Supposons que vous avez un modèle User
    
        // Passer le projet et les utilisateurs à la vue
        return view('admin.projects.show', compact('project', 'users'));
    }

    // Approuver un projet
    public function approveProject($id)
    {
        $project = Project::findOrFail($id);
        $project->approve();

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $project->ClientID,
            'Message' => 'Le projet "' . $project->Title . '" a été approuvé par l\'administrateur.',
        ]);

        return redirect()->route('admin.projects')->with('success', 'Projet approuvé avec succès.');
    }

    // Refuser un projet
    public function rejectProject($id)
    {
        $project = Project::findOrFail($id);
        $project->reject();

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $project->ClientID,
            'Message' => 'Le projet "' . $project->Title . '" a été refusé par l\'administrateur.',
        ]);

        return redirect()->route('admin.projects')->with('success', 'Projet refusé avec succès.');
    }

    // Affecter un projet à un utilisateur
    public function assignProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);

        // Affecter le projet à l'utilisateur
        $project->ClientID = $userId;
        $project->save();

        // Envoyer une notification au client
        Notification::create([
            'UserID' => $userId,
            'Message' => 'Le projet "' . $project->Title . '" vous a été affecté par l\'administrateur.',
        ]);

        return redirect()->route('admin.projects.show', $id)->with('success', 'Projet affecté avec succès.');
    }
}