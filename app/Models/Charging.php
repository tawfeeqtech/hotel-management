<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charging extends Model
{
    protected $fillable = [
        'customer_name',
//        'device_id',
//        'with_charger',
//        'card_id',
//        'location_id',
//        'charging_start_time',
        'payment_status',
        'remaining_value',
        'total_price',
//        'receiving_status'
    ];

    use HasFactory;
//
//    public function card()
//    {
//        return $this->belongsTo(Card::class);
//    }
    /*public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }*/

    public function details()
    {
        return $this->hasMany(ChargingDetails::class);
    }

}
