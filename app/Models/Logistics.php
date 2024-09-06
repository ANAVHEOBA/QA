<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id', 'status', 'departure_time', 'arrival_time'
    ];
}
