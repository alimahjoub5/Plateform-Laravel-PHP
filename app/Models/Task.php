<?php

// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $primaryKey = 'TaskID';

    protected $fillable = [
        'Title',
        'Description',
        'ProjectID',
        'AssignedTo',
        'Status',
        'Priority',
        'StartDate',
        'DueDate',
        'EstimatedHours',
        'ActualHours',
        'CompletionPercentage'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID', 'ProjectID');
    }

    public function assignedDeveloper()
    {
        return $this->belongsTo(User::class, 'AssignedTo', 'UserID');
    }

    public function timeTracks()
    {
        return $this->hasMany(TimeTracking::class, 'TaskID');
    }

    // Relation avec les commentaires
    public function comments()
    {
        return $this->hasMany(TaskComment::class, 'TaskID', 'TaskID');
    }

    // Relation avec les fichiers attachés
    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class, 'TaskID', 'TaskID');
    }
}
