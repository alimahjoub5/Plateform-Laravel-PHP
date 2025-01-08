<?php

// app/Models/Testimonial.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $primaryKey = 'TestimonialID';

    protected $fillable = [
        'ClientID', 'ProjectID', 'Feedback', 'Rating', 'IsApproved'
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(User::class, 'ClientID');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }
}
