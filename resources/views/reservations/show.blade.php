
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Reservation Details</h2>

        <a href="{{ route('reservations.index') }}"
           class="btn btn-secondary">
            Back to Reservations
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            Reservation Information
        </div>

        <div class="card-body">
            <p>
                <strong>Reservation ID:</strong>
                {{ $reservation->id }}
            </p>

            <p>
                <strong>Guest:</strong>
                {{ $reservation->guest->first_name }}
                {{ $reservation->guest->last_name }}
            </p>

            <p>
                <strong>Room:</strong>
                {{ $reservation->room->room_number }}
            </p>

            <p>
                <strong>Room Type:</strong>
                {{ $reservation->room->roomType->name }}
            </p>

            <p>
                <strong>Check-in:</strong>
                {{ $reservation->check_in }}
            </p>

            <p>
                <strong>Check-out:</strong>
                {{ $reservation->check_out }}
            </p>

            <p>
                <strong>Total Amount:</strong>
                ₱{{ number_format($reservation->total_amount, 2) }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ ucfirst($reservation->status) }}
            </p>

            <a href="{{ route('reservations.edit', $reservation) }}"
               class="btn btn-warning">
                Edit Reservation
            </a>
        </div>
    </div>
</div>
@endsection
