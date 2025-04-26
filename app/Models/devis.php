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
        'Statut',
        'ConditionsGenerales',
        'signature',
    ];

 // Relation avec l'utilisateur qui a créé le devis
 public function createdBy()
 {
     return $this->belongsTo(User::class, 'CreatedBy', 'UserID');
 }

 // Relations existantes
 public function client()
 {
     return $this->belongsTo(User::class, 'ClientID', 'UserID');
 }

 public function project()
 {
     return $this->belongsTo(Project::class, 'ProjectID', 'ProjectID');
 }
}

