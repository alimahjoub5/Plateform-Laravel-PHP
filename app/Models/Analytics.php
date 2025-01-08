<?php

// app/Models/Analytics.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    protected $primaryKey = 'AnalyticsID';

    protected $fillable = [
        'PageVisited', 'UserID', 'Action', 'DeviceType'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
