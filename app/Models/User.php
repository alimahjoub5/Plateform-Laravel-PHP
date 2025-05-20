<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'UserID';

    protected $fillable = [
        'Username',
        'Email',
        'PasswordHash',
        'FirstName',
        'LastName',
        'PhoneNumber',
        'Address',
        'Role',
        'ProfilePicture',
        'Bio',
        'Language',
        'email_verified_at'
    ];

    protected $hidden = [
        'PasswordHash',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Utiliser 'Username' comme identifiant de connexion
    public function username()
    {
        return 'Username';
    }

    // Utiliser 'PasswordHash' comme mot de passe pour l'authentification
    public function getAuthPassword()
    {
        return $this->PasswordHash;
    }

    // Méthode pour la vérification d'email
    public function getEmailForVerification()
    {
        return $this->Email;
    }

    // Méthode pour envoyer la notification de vérification
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }

    // Relations
    public function projects()
    {
        return $this->hasMany(Project::class, 'ClientID', 'UserID');
    }

    public function analytics()
    {
        return $this->hasMany(Analytics::class, 'UserID');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'AuthorID', 'UserID');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'SenderID', 'UserID');
    }

    public function assignedProjects()
    {
        return $this->hasMany(Project::class, 'DeveloperID', 'UserID');
    }

    // Méthodes de vérification de rôle
    public function isAdmin()
    {
        return strtolower($this->Role) === 'admin';
    }

    public function isClient()
    {
        return strtolower($this->Role) === 'client';
    }

    public function isEmployee()
    {
        return in_array(strtolower($this->Role), ['developer', 'designer', 'chef_projet']);
    }
}