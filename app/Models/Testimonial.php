<?php

// app/Models/Testimonial.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $primaryKey = 'TestimonialID';

    protected $fillable = [
        'ClientID',
        'ProjectID',
        'Content',
        'Rating',
        'Status',
        'AdminComment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'ClientID', 'UserID');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID', 'ProjectID');
    }

    // Scope pour les témoignages approuvés
    public function scopeApproved($query)
    {
        return $query->where('Status', 'Approved');
    }

    // Scope pour les témoignages en attente
    public function scopePending($query)
    {
        return $query->where('Status', 'Pending');
    }
}
