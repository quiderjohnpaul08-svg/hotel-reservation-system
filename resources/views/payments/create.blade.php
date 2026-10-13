
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add Payment</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Reservation</label>

            <select name="reservation_id" class="form-select" required>
                <option value="">Select Reservation</option>

                @foreach ($reservations as $reservation)
                    <option value="{{ $reservation->id }}"
                        {{ old('reservation_id') == $reservation->id ? 'selected' : '' }}>
                        Reservation #{{ $reservation->id }}
                        - {{ $reservation->guest->first_name }}
                        {{ $reservation->guest->last_name }}
                        - Room {{ $reservation->room->room_number }}
                        - ₱{{ number_format($reservation->total_amount, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (₱)</label>

            <input type="number"
                   name="amount"
                   class="form-control"
                   value="{{ old('amount') }}"
                   min="0.01"
                   step="0.01"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Date</label>

            <input type="date"
                   name="payment_date"
                   class="form-control"
                   value="{{ old('payment_date', date('Y-m-d')) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Method</label>

            <select name="payment_method" class="form-select" required>
                <option value="">Select Payment Method</option>
                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                <option value="GCash" {{ old('payment_method') == 'GCash' ? 'selected' : '' }}>GCash</option>
                <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>

            <select name="status" class="form-select" required>
                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Payment</button>

        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
