<?php

// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'TaskID';

    protected $fillable = [
        'ProjectID', 'Title', 'Description', 'AssignedTo', 'Status', 'DueDate'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }

    public function assignedDeveloper()
    {
        return $this->belongsTo(User::class, 'AssignedTo');
    }

    public function timeTracks()
    {
        return $this->hasMany(TimeTracking::class, 'TaskID');
    }
}
