<?php

// app/Models/Notification.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'NotificationID';

    protected $fillable = [
        'UserID', 'Message', 'IsRead', 'Type'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('IsRead', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('Type', $type);
    }
}
