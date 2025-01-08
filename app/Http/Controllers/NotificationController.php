<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Afficher la liste des notifications
    public function index()
    {
        $notifications = Notification::where('UserID', auth()->id())->get();
        return view('notifications.index', compact('notifications'));
    }

    // Afficher le formulaire de création d'une notification
    public function create()
    {
        return view('notifications.create');
    }

    // Enregistrer une nouvelle notification
    public function store(Request $request)
    {
        $request->validate([
            'Message' => 'required|string|max:255',
        ]);

        Notification::create([
            'UserID' => auth()->id(),
            'Message' => $request->input('Message'),
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification créée avec succès.');
    }

    // Afficher une notification spécifique
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        return view('notifications.show', compact('notification'));
    }

    // Marquer une notification comme lue
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['IsRead' => true]);

        return redirect()->route('notifications.index')->with('success', 'Notification marquée comme lue.');
    }

    // Supprimer une notification
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification supprimée avec succès.');
    }
}