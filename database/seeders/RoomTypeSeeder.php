<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            ['name' => 'Standard Room', 'description' => 'A comfortable room for short stays.'],
            ['name' => 'Deluxe Room', 'description' => 'A larger room with extra amenities.'],
            
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::factory()->create($roomType);
        }
    }
}
