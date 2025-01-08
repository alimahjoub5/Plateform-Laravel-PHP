<?php

// app/Models/Portfolio.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $primaryKey = 'PortfolioID';

    protected $fillable = [
        'ProjectID', 'Title', 'Description', 'ImageURL', 'LiveLink', 'Category', 'Tags'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }
}