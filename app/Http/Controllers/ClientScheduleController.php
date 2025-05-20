<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientScheduleController extends Controller
{
    public function index()
    {
        // Récupérer l'ID du client connecté
        $clientId = auth()->id();

        // Récupérer les réunions du client
        $meetings = Meeting::where('client_id', $clientId)
            ->orWhereHas('project', function($query) use ($clientId) {
                $query->where('ClientID', $clientId);
            })
            ->get()
            ->map(function($meeting) {
                return [
                    'title' => $meeting->title,
                    'start_date' => $meeting->start_time,
                    'end_date' => $meeting->end_time,
                    'description' => $meeting->description,
                    'color' => '#3B82F6' // Bleu pour les réunions
                ];
            });

        // Récupérer les dates importantes des projets du client
        $projectEvents = Project::where('ClientID', $clientId)
            ->get()
            ->map(function($project) {
                return [
                    'title' => 'Projet: ' . $project->Title,
                    'start_date' => $project->StartDate,
                    'end_date' => $project->EndDate,
                    'description' => $project->Description,
                    'color' => '#10B981' // Vert pour les projets
                ];
            });

        // Combiner tous les événements
        $events = $meetings->concat($projectEvents);

        return view('client.schedule', compact('events'));
    }
} 