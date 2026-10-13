<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = Guest::all();
        $rooms = Room::all();

        foreach (range(1, 5) as $number) {
            $room = $rooms->random();
            $checkIn = now()->addDays(fake()->numberBetween(-10, 60));
            $nights = fake()->numberBetween(1, 7);
            $checkOut = $checkIn->copy()->addDays($nights);

            Reservation::factory()->create([
                'guest_id' => $guests->random()->id,
                'room_id' => $room->id,
                'check_in' => $checkIn->toDateString(),
                'check_out' => $checkOut->toDateString(),
                'total_amount' => round((float) $room->price_per_night * $nights, 2),
            ]);
        }
    }
}
