<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = Reservation::all();

        foreach ($reservations->take(5) as $reservation) {
            Payment::factory()->create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->total_amount,
            ]);
        }
    }
}
