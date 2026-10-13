<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = RoomType::all();

        foreach (range(10, 15) as $roomNumber) {
            Room::factory()->create([
                'room_number' => (string) $roomNumber,
                'room_type_id' => $roomTypes->random()->id,
            ]);
        }
    }
}
