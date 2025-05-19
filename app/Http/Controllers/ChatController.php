<?php

// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getMessages(Request $request)
    {
        $receiverId = $request->query('receiver_id');
        
        $messages = ChatMessage::where(function($query) use ($receiverId) {
            $query->where('SenderID', auth()->id())
                  ->where('ReceiverID', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('SenderID', $receiverId)
                  ->where('ReceiverID', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Marquer les messages comme lus
        ChatMessage::where('SenderID', $receiverId)
                   ->where('ReceiverID', auth()->id())
                   ->where('IsRead', false)
                   ->update(['IsRead' => true]);

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,UserID',
        ]);

        $message = ChatMessage::create([
            'SenderID' => auth()->id(),
            'ReceiverID' => $request->receiver_id,
            'Message' => $request->message,
            'IsRead' => false,
        ]);

        return response()->json(['success' => true]);
    }

    private function getReceiverId($projectId)
    {
        // Logic to determine the receiver ID based on the project and current user
        // Example: If the current user is the client, the receiver is the developer, and vice versa
        $project = Project::find($projectId);
        return auth()->id() === $project->client_id ? $project->developer_id : $project->client_id;
    }

    public function index($projectId)
    {
        try {
            $project = Project::with(['client', 'messages.sender'])->findOrFail($projectId);
            $messages = $project->messages()->with('sender')->orderBy('created_at', 'asc')->get();
            
            return view('chat.index', compact('project', 'messages'));
        } catch (\Exception $e) {
            return view('chat.no-project');
        }
    }

    public function store(Request $request, $projectId)
    {
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:10240' // Max 10MB
        ]);

        $message = new ChatMessage();
        $message->ProjectID = $projectId;
        $message->SenderID = Auth::id();
        $message->Message = $request->message;

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('chat-attachments', 'public');
            $message->AttachmentURL = $path;
        }

        $message->save();

        return redirect()->back()->with('success', 'Message envoyé avec succès');
    }

    public function markAsRead($messageId)
    {
        $message = ChatMessage::findOrFail($messageId);
        $message->IsRead = true;
        $message->save();

        return response()->json(['success' => true]);
    }

    public function list()
    {
        $currentUser = auth()->user();
        
        // Récupérer les clients avec lesquels l'utilisateur actuel a des conversations
        $clients = User::where('Role', 'Client')
            ->where(function($query) use ($currentUser) {
                $query->whereExists(function($q) use ($currentUser) {
                    $q->select('*')
                      ->from('chat_messages')
                      ->whereColumn('chat_messages.SenderID', 'users.UserID')
                      ->where('chat_messages.ReceiverID', $currentUser->UserID);
                })->orWhereExists(function($q) use ($currentUser) {
                    $q->select('*')
                      ->from('chat_messages')
                      ->whereColumn('chat_messages.ReceiverID', 'users.UserID')
                      ->where('chat_messages.SenderID', $currentUser->UserID);
                });
            })
            ->with(['projects' => function($query) {
                $query->where('Status', 'In Progress')
                    ->orWhere('Status', 'Pending');
            }])
            ->with(['messages' => function($query) use ($currentUser) {
                $query->where(function($q) use ($currentUser) {
                    $q->where('SenderID', $currentUser->UserID)
                      ->orWhere('ReceiverID', $currentUser->UserID);
                })->latest()->first();
            }])
            ->get()
            ->map(function($client) use ($currentUser) {
                $client->isOnline = $client->last_seen_at && $client->last_seen_at->diffInMinutes(now()) < 5;
                $client->lastMessage = $client->messages->first();
                $client->unreadCount = ChatMessage::where('SenderID', $client->UserID)
                    ->where('ReceiverID', $currentUser->UserID)
                    ->where('IsRead', false)
                    ->count();
                return $client;
            });

        return view('chat.list', compact('clients'));
    }

    public function show($clientId)
    {
        // Vérifier si l'utilisateur actuel est autorisé à voir cette conversation
        $currentUser = auth()->user();
        $client = User::where('Role', 'Client')
            ->where('UserID', $clientId)
            ->firstOrFail();

        // Vérifier si l'utilisateur actuel est admin ou a une relation avec le client
        if (!$currentUser->isAdmin() && !$currentUser->isEmployee()) {
            // Si l'utilisateur n'est pas admin ou employé, vérifier s'il est le client lui-même
            if ($currentUser->UserID !== $clientId) {
                abort(403, 'Accès non autorisé à cette conversation.');
            }
        }

        // Récupérer les messages entre l'utilisateur actuel et le client
        $messages = ChatMessage::where(function($query) use ($currentUser, $clientId) {
            $query->where(function($q) use ($currentUser, $clientId) {
                $q->where('SenderID', $currentUser->UserID)
                  ->where('ReceiverID', $clientId);
            })->orWhere(function($q) use ($currentUser, $clientId) {
                $q->where('SenderID', $clientId)
                  ->where('ReceiverID', $currentUser->UserID);
            });
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Marquer les messages non lus comme lus
        ChatMessage::where('SenderID', $clientId)
                   ->where('ReceiverID', $currentUser->UserID)
                   ->where('IsRead', false)
                   ->update(['IsRead' => true]);

        return view('chat.show', compact('client', 'messages'));
    }
}
