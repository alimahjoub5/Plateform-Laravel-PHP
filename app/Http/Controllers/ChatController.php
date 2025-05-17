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
        $projectId = $request->query('project_id');
        $messages = ChatMessage::where('project_id', $projectId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        ChatMessage::where('project_id', $projectId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $unreadCount = ChatMessage::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'messages' => $messages,
            'unread_count' => $unreadCount,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create([
            'project_id' => $request->project_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->getReceiverId($request->project_id),
            'message' => $request->message,
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
}
