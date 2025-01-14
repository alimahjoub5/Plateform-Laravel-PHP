<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'UserID'; // Définir la clé primaire personnalisée

    protected $fillable = [
        'Username',
        'Email',
        'PasswordHash',
        'Role',
        'ProfilePicture',
        'Bio',
        'Language',
    ];

    protected $hidden = [
        'PasswordHash', // Cacher le mot de passe
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Utiliser 'PasswordHash' comme mot de passe pour l'authentification
    public function getAuthPassword()
    {
        return $this->PasswordHash;
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'ClientID', 'UserID');
    }

    public function analytics()
    {
        return $this->hasMany(Analytics::class, 'UserID');
    }
    
    // Utiliser 'Username' comme identifiant de connexion
    public function username()
    {
        return 'Username';
    }

    // Relation avec les blogs
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'AuthorID', 'UserID');
    }

    // Dans le modèle User
public function isAdmin() {
    return $this->role === 'admin';
}

public function isClient() {
    return $this->role === 'client';
}
}