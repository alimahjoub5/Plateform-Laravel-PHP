<?php

// app/Models/Invoice.php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $primaryKey = 'InvoiceID';

    protected $fillable = [
        'ProjectID', 'ClientID', 'Amount', 'Status', 'DueDate'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class, 'ProjectID');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'ClientID');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id', 'InvoiceID');
    }
}
