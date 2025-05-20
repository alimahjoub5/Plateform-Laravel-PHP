<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    protected $fillable = [
        'devis_id',
        'message',
        'sender_type',
        'sender_id'
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class, 'devis_id', 'DevisID');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'UserID');
    }
} 