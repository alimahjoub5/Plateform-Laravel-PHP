<?php

// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;

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
}
