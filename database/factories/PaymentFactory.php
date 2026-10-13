<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'amount' => function (array $attributes): float {
                $reservation = Reservation::find($attributes['reservation_id']);

                return (float) ($reservation?->total_amount ?? fake()->randomFloat(2, 80, 1200));
            },
            'payment_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'payment_method' => fake()->randomElement(['cash', 'credit card', 'debit card', 'online transfer']),
            'status' => fake()->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
