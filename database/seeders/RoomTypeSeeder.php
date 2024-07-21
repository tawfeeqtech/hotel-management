<?php

namespace Database\Seeders;

use App\Models\RoomTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            'Single', 
            'Double', 
            'Quad', 
            'King', 
            'Suite', 
            'Villa', 
        ];
        
        foreach ($roomTypes as $roomType) {
            RoomTypes::create(['room_name' => $roomType]);
        }
    }
}
