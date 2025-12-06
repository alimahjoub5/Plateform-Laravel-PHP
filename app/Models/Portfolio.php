<?php



// app/Models/Portfolio.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }
}