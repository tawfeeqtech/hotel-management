<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = ['place_number'];

    public function chargings()
    {
        return $this->hasMany(Charging::class);
    }
}
