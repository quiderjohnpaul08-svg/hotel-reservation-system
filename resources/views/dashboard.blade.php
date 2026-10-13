
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4">Hotel Dashboard</h1>

<div class="row g-3">
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Guests</h6>
                <h2>{{ $guestCount }}</h2>
                <a href="{{ route('guests.index') }}">Manage Guests</a>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Rooms</h6>
                <h2>{{ $roomCount }}</h2>
                <a href="{{ route('rooms.index') }}">Manage Rooms</a>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Room Types</h6>
                <h2>{{ $roomTypeCount }}</h2>
                <a href="{{ route('room-types.index') }}">Manage Room Types</a>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Reservations</h6>
                <h2>{{ $reservationCount }}</h2>
                <a href="{{ route('reservations.index') }}">Manage Reservations</a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h5>Total Payments Received</h5>
        <h2>₱{{ number_format((float) $paymentTotal, 2) }}</h2>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h5>Recent Reservations</h5>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentReservations as $reservation)
                        <tr>
                            <td>
                                {{ $reservation->guest->first_name }}
                                {{ $reservation->guest->last_name }}
                            </td>
                            <td>{{ $reservation->room->room_number }}</td>
                            <td>{{ $reservation->check_in->format('M d, Y') }}</td>
                            <td>{{ $reservation->check_out->format('M d, Y') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $reservation->status)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No reservations yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
