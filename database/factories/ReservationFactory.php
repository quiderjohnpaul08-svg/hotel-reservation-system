<?php

namespace Database\Factories;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkIn = fake()->dateTimeBetween('-1 month', '+2 months');
        $nights = fake()->numberBetween(1, 7);
        $checkOut = (clone $checkIn)->modify("+{$nights} days");

        return [
            'guest_id' => Guest::factory(),
            'room_id' => Room::factory(),
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'total_amount' => function (array $attributes) use ($nights): float {
                $room = Room::find($attributes['room_id']);
                $pricePerNight = (float) ($room?->price_per_night ?? fake()->randomFloat(2, 80, 450));

                return round($pricePerNight * $nights, 2);
            },
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
        ];
    }
}
