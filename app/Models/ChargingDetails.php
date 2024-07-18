<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargingDetails extends Model
{
    protected $fillable = [
        'charging_id',
        'card_id',
        'device_id',
        'with_charger',
        'location_id',
        'receiving_status',
        'delivery_time',
        'charging_start_time',

    ];

    use HasFactory;

    public function charging()
    {
        return $this->belongsTo(Charging::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
