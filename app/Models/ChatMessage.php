<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'project_id',
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
    ];

    // Relationship to the project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relationship to the sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship to the receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

