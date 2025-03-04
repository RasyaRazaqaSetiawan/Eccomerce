<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'tracking_number', 'status', 'estimated'];

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
