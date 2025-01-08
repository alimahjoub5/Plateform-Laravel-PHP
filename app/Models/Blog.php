<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $primaryKey = 'BlogID';

    protected $fillable = [
        'Title', 'Content', 'AuthorID', 'Category', 'FeaturedImage'
    ];

    // Relation avec l'auteur
    public function author()
    {
        return $this->belongsTo(User::class, 'AuthorID', 'UserID');
    }
}