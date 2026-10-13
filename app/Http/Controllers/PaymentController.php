<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with([
            'reservation.guest',
            'reservation.room',
        ])->latest()->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create(): View
    {
        $reservations = Reservation::with([
            'guest',
            'room.roomType',
        ])->whereDoesntHave('payments', function (Builder $query): void {
            $query->where('status', 'paid');
        })->latest()->get();

        return view('payments.create', compact('reservations'));
    }

    public function store(Request $request): RedirectResponse
    {
        Payment::create($this->validatePayment($request));

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment added successfully.');
    }

    public function show(Payment $payment): View
    {
        $payment->load([
            'reservation.guest',
            'reservation.room.roomType',
        ]);

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment): View
    {
        $reservations = Reservation::with([
            'guest',
            'room.roomType',
        ])->latest()->get();

        return view('payments.edit', compact('payment', 'reservations'));
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $payment->update($this->validatePayment($request));

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    /**
     * @return array{
     *     reservation_id: int|string,
     *     amount: float|int|string,
     *     payment_date: string,
     *     payment_method: string,
     *     status: string
     * }
     */
    private function validatePayment(Request $request): array
    {
        return $request->validate([
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', Rule::in(['Cash', 'Credit Card', 'GCash', 'Bank Transfer'])],
            'status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
        ]);
    }
}
