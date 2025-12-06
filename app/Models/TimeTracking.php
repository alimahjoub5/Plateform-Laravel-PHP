<?php



// app/Models/TimeTracking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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