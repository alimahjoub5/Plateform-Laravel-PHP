<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'devis';

    // Clé primaire de la table
    protected $primaryKey = 'DevisID';

    // Champs remplissables (mass assignable)
    protected $fillable = [
        'ProjectID',
        'ClientID',
        'Reference',
        'DateEmission',
        'DateValidite',
        'TotalHT',
        'TVA',
        'TotalTTC',
        'ConditionsGenerales',
        'Statut',
        'CreatedBy',
        'signature'
    ];

    protected $casts = [
        'DateEmission' => 'date',
        'DateValidite' => 'date',
        'TotalHT' => 'decimal:2',
        'TVA' => 'decimal:2',
        'TotalTTC' => 'decimal:2',
    ];

    // Relation avec le projet
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID', 'ProjectID');
    }

    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(User::class, 'ClientID', 'UserID');
    }

    // Relation avec le créateur
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'UserID');
    }

    // Relation avec les lignes du devis
    public function lignes()
    {
        return $this->hasMany(DevisLigne::class, 'DevisID', 'DevisID');
    }
}

