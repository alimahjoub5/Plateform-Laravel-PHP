<?php

// app/Models/Service.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'ServiceID';

    protected $fillable = [
        'ServiceName', 'Description', 'Price', 'Category', 'IsAvailable'
    ];
}