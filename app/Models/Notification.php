<?php

// app/Models/Notification.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'NotificationID';

    protected $fillable = [
        'UserID', 'Message', 'IsRead'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
