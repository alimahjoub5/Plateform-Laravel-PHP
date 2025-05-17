<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $primaryKey = 'MessageID';

    protected $fillable = [
        'ProjectID',
        'SenderID',
        'Message',
        'IsRead',
        'AttachmentURL'
    ];

    protected $casts = [
        'IsRead' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relation avec le projet
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID', 'ProjectID');
    }

    // Relation avec l'expéditeur
    public function sender()
    {
        return $this->belongsTo(User::class, 'SenderID', 'UserID');
    }

    // Relationship to the receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

