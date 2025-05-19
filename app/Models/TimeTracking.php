<?php

// app/Models/TimeTracking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTracking extends Model
{
    protected $table = 'time_tracking';
    protected $primaryKey = 'TrackingID';

    protected $fillable = [
        'UserID',
        'TaskID',
        'Description',
        'StartTime',
        'EndTime'
    ];

    protected $casts = [
        'StartTime' => 'datetime',
        'EndTime' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'TaskID', 'TaskID');
    }
}