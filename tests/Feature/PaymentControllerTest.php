<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_payload_creates_payment(): void
    {
        $reservation = $this->createReservation();

        $response = $this->post(route('payments.store'), [
            'reservation_id' => $reservation->id,
            'amount' => '500.00',
            'payment_date' => '2026-11-01',
            'payment_method' => 'Cash',
            'status' => 'paid',
        ]);

        $response
            ->assertRedirect(route('payments.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('payments', [
            'reservation_id' => $reservation->id,
            'amount' => '500.00',
            'payment_date' => '2026-11-01',
            'payment_method' => 'Cash',
            'status' => 'paid',
        ]);
    }

    public function test_create_form_does_not_show_reservations_with_paid_payments(): void
    {
        $paidReservation = $this->createReservation('101');
        $availableReservation = $this->createReservation('102');

        Payment::create([
            'reservation_id' => $paidReservation->id,
            'amount' => '500.00',
            'payment_date' => '2026-11-01',
            'payment_method' => 'Cash',
            'status' => 'paid',
        ]);

        $response = $this->get(route('payments.create'));

        $response
            ->assertOk()
            ->assertSee('Reservation #'.$availableReservation->id)
            ->assertDontSee('Reservation #'.$paidReservation->id);
    }

    public function test_invalid_payload_does_not_create_payment(): void
    {
        $response = $this
            ->from(route('payments.create'))
            ->post(route('payments.store'), []);

        $response
            ->assertRedirect(route('payments.create'))
            ->assertInvalid([
                'reservation_id' => 'The reservation id field is required.',
                'amount' => 'The amount field is required.',
                'payment_date' => 'The payment date field is required.',
                'payment_method' => 'The payment method field is required.',
                'status' => 'The status field is required.',
            ]);

        $this->assertDatabaseEmpty('payments');
    }

    public function test_valid_payload_updates_payment(): void
    {
        $payment = $this->createPayment();
        $reservation = $this->createReservation('102');

        $response = $this->put(route('payments.update', $payment), [
            'reservation_id' => $reservation->id,
            'amount' => '750.00',
            'payment_date' => '2026-11-02',
            'payment_method' => 'GCash',
            'status' => 'pending',
        ]);

        $response
            ->assertRedirect(route('payments.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'reservation_id' => $reservation->id,
            'amount' => '750.00',
            'payment_date' => '2026-11-02',
            'payment_method' => 'GCash',
            'status' => 'pending',
        ]);
    }

    public function test_payment_can_be_deleted(): void
    {
        $payment = $this->createPayment();

        $response = $this->delete(route('payments.destroy', $payment));

        $response
            ->assertRedirect(route('payments.index'))
            ->assertSessionHas('success', 'Payment deleted successfully.');

        $this->assertDatabaseMissing('payments', [
            'id' => $payment->id,
        ]);
    }

    private function createPayment(): Payment
    {
        return Payment::create([
            'reservation_id' => $this->createReservation()->id,
            'amount' => '500.00',
            'payment_date' => '2026-11-01',
            'payment_method' => 'Cash',
            'status' => 'paid',
        ]);
    }

    private function createReservation(string $roomNumber = '101'): Reservation
    {
        return Reservation::create([
            'guest_id' => $this->createGuest()->id,
            'room_id' => $this->createRoom($roomNumber)->id,
            'check_in' => '2026-11-01',
            'check_out' => '2026-11-03',
            'total_amount' => '1500.00',
            'status' => 'pending',
        ]);
    }

    private function createGuest(): Guest
    {
        return Guest::create([
            'first_name' => 'Ritchie',
            'last_name' => 'Coscos',
            'email' => fake()->unique()->safeEmail(),
            'phone' => '09123456789',
            'address' => 'Tubigon',
        ]);
    }

    private function createRoom(string $roomNumber): Room
    {
        $roomType = RoomType::create([
            'name' => 'Type '.$roomNumber,
            'description' => null,
        ]);

        return Room::create([
            'room_number' => $roomNumber,
            'room_type_id' => $roomType->id,
            'price_per_night' => '750.00',
            'status' => 'available',
        ]);
    }
}
