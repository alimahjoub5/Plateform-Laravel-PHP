<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    // Afficher le calendrier des réunions
    public function index()
    {
        $meetings = Meeting::with(['project', 'organizer', 'attendees'])->get();
        return view('meetings.index', compact('meetings'));
    }

    // Afficher le formulaire de création d'une réunion
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('meetings.create', compact('projects', 'users'));
    }

    // Enregistrer une nouvelle réunion
    public function store(Request $request)
    {
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'Title' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'StartTime' => 'required|date',
            'EndTime' => 'required|date|after:StartTime',
            'Location' => 'nullable|string',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:users,UserID',
        ]);

        $meeting = Meeting::create([
            'ProjectID' => $request->ProjectID,
            'OrganizerID' => auth()->id(), // L'organisateur est l'utilisateur connecté
            'Title' => $request->Title,
            'Description' => $request->Description,
            'StartTime' => $request->StartTime,
            'EndTime' => $request->EndTime,
            'Location' => $request->Location,
        ]);

        // Ajouter les participants
        if ($request->has('attendees')) {
            $meeting->attendees()->attach($request->attendees);
        }

        return redirect()->route('meetings.index')->with('success', 'Réunion créée avec succès.');
    }

    // Afficher les détails d'une réunion spécifique
public function show($id)
{
    // Récupérer la réunion avec ses relations
    $meeting = Meeting::with(['project', 'organizer', 'attendees'])->findOrFail($id);

    // Passer la réunion à la vue
    return view('meetings.show', compact('meeting'));
}

public function edit($id)
{
    $meeting = Meeting::findOrFail($id);
    $projects = Project::all();
    $users = User::all();
    return view('meetings.edit', compact('meeting', 'projects', 'users'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'ProjectID' => 'required|exists:projects,ProjectID',
        'Title' => 'required|string|max:255',
        'Description' => 'nullable|string',
        'StartTime' => 'required|date',
        'EndTime' => 'required|date|after:StartTime',
        'Location' => 'nullable|string',
        'attendees' => 'nullable|array',
        'attendees.*' => 'exists:users,UserID',
    ]);

    $meeting = Meeting::findOrFail($id);
    $meeting->update([
        'ProjectID' => $request->ProjectID,
        'Title' => $request->Title,
        'Description' => $request->Description,
        'StartTime' => $request->StartTime,
        'EndTime' => $request->EndTime,
        'Location' => $request->Location,
    ]);

    // Synchroniser les participants
    if ($request->has('attendees')) {
        $meeting->attendees()->sync($request->attendees);
    }

    return redirect()->route('meetings.index')->with('success', 'Réunion mise à jour avec succès.');
}

public function destroy($id)
{
    $meeting = Meeting::findOrFail($id);
    $meeting->attendees()->detach(); // Supprimer les relations avec les participants
    $meeting->delete();

    return redirect()->route('meetings.index')->with('success', 'Réunion supprimée avec succès.');
}


public function calendarData()
{
    // Récupérer l'utilisateur connecté
    $user = auth()->user();

    // Récupérer les réunions de l'utilisateur (en tant qu'organisateur ou participant)
    $meetings = Meeting::where('OrganizerID', $user->UserID)
        ->orWhereHas('attendees', function ($query) use ($user) {
            $query->where('UserID', $user->UserID);
        })
        ->get();

    // Formater les réunions pour FullCalendar
    $formattedMeetings = $meetings->map(function ($meeting) {
        return [
            'id' => $meeting->MeetingID,
            'title' => $meeting->Title,
            'start' => $meeting->StartTime->toIso8601String(),
            'end' => $meeting->EndTime->toIso8601String(),
            'color' => $meeting->OrganizerID === auth()->id() ? '#2563eb' : '#10b981', // Couleur différente pour l'organisateur
        ];
    });

    return response()->json($formattedMeetings);
}

public function calendar()
{
    return view('meetings.calendar');
}

}