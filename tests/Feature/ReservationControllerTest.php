<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_payload_creates_reservation(): void
    {
        $guest = $this->createGuest();
        $room = $this->createRoom('101');

        $response = $this->post(route('reservations.store'), [
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in' => '2026-11-01',
            'check_out' => '2026-11-03',
            'total_amount' => '1500.00',
            'status' => 'confirmed',
        ]);

        $response
            ->assertRedirect(route('reservations.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('reservations', [
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in' => '2026-11-01',
            'check_out' => '2026-11-03',
            'total_amount' => '1500.00',
            'status' => 'confirmed',
        ]);
    }

    public function test_valid_payload_updates_reservation(): void
    {
        $reservation = $this->createReservation();
        $newRoom = $this->createRoom('102');

        $response = $this->put(route('reservations.update', $reservation), [
            'guest_id' => $reservation->guest_id,
            'room_id' => $newRoom->id,
            'check_in' => '2026-12-05',
            'check_out' => '2026-12-08',
            'total_amount' => '2400.00',
            'status' => 'completed',
        ]);

        $response
            ->assertRedirect(route('reservations.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'room_id' => $newRoom->id,
            'check_in' => '2026-12-05',
            'check_out' => '2026-12-08',
            'total_amount' => '2400.00',
            'status' => 'completed',
        ]);
    }

    public function test_update_rejects_unavailable_room_that_is_not_current(): void
    {
        $reservation = $this->createReservation();
        $unavailableRoom = $this->createRoom('103', 'unavailable');

        $response = $this
            ->from(route('reservations.edit', $reservation))
            ->put(route('reservations.update', $reservation), [
                'guest_id' => $reservation->guest_id,
                'room_id' => $unavailableRoom->id,
                'check_in' => '2026-12-05',
                'check_out' => '2026-12-08',
                'total_amount' => '2400.00',
                'status' => 'completed',
            ]);

        $response
            ->assertRedirect(route('reservations.edit', $reservation))
            ->assertInvalid([
                'room_id' => 'The selected room id is invalid.',
            ]);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'room_id' => $reservation->room_id,
        ]);
    }

    public function test_reservation_without_payments_can_be_deleted(): void
    {
        $reservation = $this->createReservation();

        $response = $this->delete(route('reservations.destroy', $reservation));

        $response
            ->assertRedirect(route('reservations.index'))
            ->assertSessionHas('success', 'Reservation deleted successfully.');

        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }

    public function test_reservation_with_payments_is_not_deleted(): void
    {
        $reservation = $this->createReservation();

        Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => '500.00',
            'payment_date' => '2026-11-01',
            'payment_method' => 'cash',
            'status' => 'paid',
        ]);

        $response = $this->delete(route('reservations.destroy', $reservation));

        $response
            ->assertRedirect(route('reservations.index'))
            ->assertSessionHas('error', 'Cannot delete a reservation with payments.');

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
        ]);
    }

    private function createGuest(): Guest
    {
        return Guest::create([
            'first_name' => 'Ritchie',
            'last_name' => 'Coscos',
            'email' => 'ritchie@example.com',
            'phone' => '09123456789',
            'address' => 'Tubigon',
        ]);
    }

    private function createRoom(string $roomNumber, string $status = 'available'): Room
    {
        $roomType = RoomType::create([
            'name' => 'Type '.$roomNumber,
            'description' => null,
        ]);

        return Room::create([
            'room_number' => $roomNumber,
            'room_type_id' => $roomType->id,
            'price_per_night' => '750.00',
            'status' => $status,
        ]);
    }

    private function createReservation(): Reservation
    {
        return Reservation::create([
            'guest_id' => $this->createGuest()->id,
            'room_id' => $this->createRoom('101')->id,
            'check_in' => '2026-11-01',
            'check_out' => '2026-11-03',
            'total_amount' => '1500.00',
            'status' => 'pending',
        ]);
    }
}
