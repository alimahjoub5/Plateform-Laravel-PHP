<?php

// app/Models/TimeTracking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTracking extends Model
{
    protected $primaryKey = 'TimeTrackID';

    protected $fillable = [
        'TaskID', 'DeveloperID', 'StartTime', 'EndTime', 'Duration'
    ];

    // Relationships
    public function task()
    {
        return $this->belongsTo(Task::class, 'TaskID');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'DeveloperID');
    }
}