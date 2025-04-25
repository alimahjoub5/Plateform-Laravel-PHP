<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevisLigne extends Model
{
    protected $table = 'devis_lignes';
    protected $primaryKey = 'LigneID';
    public $timestamps = true;

    protected $fillable = [
        'DevisID',
        'Description',
        'Quantite',
        'PrixUnitaire',
        'TotalHT'
    ];

    protected $casts = [
        'Quantite' => 'decimal:2',
        'PrixUnitaire' => 'decimal:2',
        'TotalHT' => 'decimal:2',
    ];

    // Relation avec le devis
    public function devis()
    {
        return $this->belongsTo(Devis::class, 'DevisID', 'DevisID');
    }
} 