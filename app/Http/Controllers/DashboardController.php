<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;

class DashboardController extends Controller
{
    public function index()
    {
        $guestCount = Guest::count();
        $roomCount = Room::count();
        $roomTypeCount = RoomType::count();
        $reservationCount = Reservation::count();

        $paymentTotal = Payment::where('status', 'paid')
            ->sum('amount');

        $recentReservations = Reservation::with(['guest', 'room'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'guestCount',
            'roomCount',
            'roomTypeCount',
            'reservationCount',
            'paymentTotal',
            'recentReservations'
        ));
    }
}
