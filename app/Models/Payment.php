<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'amount', 'payment_method', 'transaction_id', 'status'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}