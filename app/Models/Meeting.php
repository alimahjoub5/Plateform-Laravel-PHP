<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Meeting extends Model
{
    protected $primaryKey = 'MeetingID';

    protected $fillable = [
        'ProjectID',
        'OrganizerID',
        'Title',
        'Description',
        'StartTime',
        'EndTime',
        'Location',
    ];

    // Convertir les colonnes de date en objets Carbon
    protected $dates = [
        'StartTime',
        'EndTime',
    ];

    // Ou, si vous utilisez Laravel 9+, utilisez $casts
    protected $casts = [
        'StartTime' => 'datetime',
        'EndTime' => 'datetime',
    ];

    // Relations
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'OrganizerID');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'meeting_attendees', 'MeetingID', 'UserID');
    }
}