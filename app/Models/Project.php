<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Définir la clé primaire
    protected $primaryKey = 'ProjectID';

    // Colonnes remplissables (mass assignable)
    protected $fillable = [
        'Title', 
        'Description', 
        'ClientID', 
        'Budget', 
        'Deadline', 
        'Status', 
        'ApprovalStatus' // Ajout de la nouvelle colonne
    ];

    // Relations
// App\Models\Project.php
public function client()
{
    return $this->belongsTo(User::class, 'ClientID', 'UserID');
}

    public function tasks()
    {
        return $this->hasMany(Task::class, 'ProjectID');
    }

    public function portfolio()
    {
        return $this->hasOne(Portfolio::class, 'ProjectID');
    }

    // Méthodes utilitaires pour gérer l'approbation
    /**
     * Vérifie si le projet est approuvé.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->ApprovalStatus === 'Approved';
    }

    /**
     * Vérifie si le projet est en attente d'approbation.
     *
     * @return bool
     */
    public function isPendingApproval(): bool
    {
        return $this->ApprovalStatus === 'Pending';
    }

    /**
     * Vérifie si le projet est refusé.
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->ApprovalStatus === 'Rejected';
    }

    /**
     * Approuve le projet.
     *
     * @return void
     */
    public function approve(): void
    {
        $this->update(['ApprovalStatus' => 'Approved']);
    }

    /**
     * Refuse le projet.
     *
     * @return void
     */
    public function reject(): void
    {
        $this->update(['ApprovalStatus' => 'Rejected']);
    }
}