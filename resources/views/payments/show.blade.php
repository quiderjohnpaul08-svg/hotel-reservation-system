
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Payment Details</h2>

        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            Back to Payments
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            Payment Information
        </div>

        <div class="card-body">
            <p>
                <strong>Payment ID:</strong>
                {{ $payment->id }}
            </p>

            <p>
                <strong>Reservation ID:</strong>
                {{ $payment->reservation_id }}
            </p>

            <p>
                <strong>Guest:</strong>
                {{ $payment->reservation->guest->first_name }}
                {{ $payment->reservation->guest->last_name }}
            </p>

            <p>
                <strong>Room:</strong>
                {{ $payment->reservation->room->room_number }}
            </p>

            <p>
                <strong>Payment Amount:</strong>
                ₱{{ number_format($payment->amount, 2) }}
            </p>

            <p>
                <strong>Payment Date:</strong>
                {{ $payment->payment_date }}
            </p>

            <p>
                <strong>Payment Method:</strong>
                {{ $payment->payment_method }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ ucfirst($payment->status) }}
            </p>

            <a href="{{ route('payments.edit', $payment) }}"
               class="btn btn-warning">
                Edit Payment
            </a>
        </div>
    </div>
</div>
@endsection
