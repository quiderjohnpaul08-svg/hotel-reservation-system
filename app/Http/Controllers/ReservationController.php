<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = Reservation::with(['guest', 'room.roomType'])
            ->latest()
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function create(): View
    {
        $guests = Guest::orderBy('first_name')->get();

        $rooms = Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();

        return view('reservations.create', compact('guests', 'rooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateReservation($request);

        Reservation::create($validated);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation added successfully.');
    }

    public function show(Reservation $reservation): View
    {
        $reservation->load(['guest', 'room.roomType']);

        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation): View
    {
        $guests = Guest::orderBy('first_name')->get();

        // Include the current room even if it is no longer available.
        $rooms = Room::with('roomType')
            ->where(function (EloquentBuilder $query) use ($reservation): void {
                $query->where('status', 'available')
                    ->orWhere('id', $reservation->room_id);
            })
            ->orderBy('room_number')
            ->get();

        return view('reservations.edit', compact('reservation', 'guests', 'rooms'));
    }

    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $validated = $this->validateReservation($request, $reservation);

        $reservation->update($validated);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        if ($reservation->payments()->exists()) {
            return redirect()
                ->route('reservations.index')
                ->with('error', 'Cannot delete a reservation with payments.');
        }

        $reservation->delete();

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }

    /**
     * @return array{
     *     guest_id: int|string,
     *     room_id: int|string,
     *     check_in: string,
     *     check_out: string,
     *     total_amount: float|int|string,
     *     status: string
     * }
     */
    private function validateReservation(Request $request, ?Reservation $reservation = null): array
    {
        return $request->validate([
            'guest_id' => ['required', 'integer', 'exists:guests,id'],
            'room_id' => [
                'required',
                'integer',
                Rule::exists('rooms', 'id')->where(function (QueryBuilder $query) use ($reservation): void {
                    $query->where(function (QueryBuilder $query) use ($reservation): void {
                        $query->where('status', 'available');

                        if ($reservation !== null) {
                            $query->orWhere('id', $reservation->room_id);
                        }
                    });
                }),
            ],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled', 'completed'])],
        ]);
    }
}
