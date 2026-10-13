
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Reservation</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.update', $reservation) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Guest</label>
            <select name="guest_id" class="form-select" required>
                <option value="">Select Guest</option>

                @foreach ($guests as $guest)
                    <option value="{{ $guest->id }}"
                        {{ old('guest_id', $reservation->guest_id) == $guest->id ? 'selected' : '' }}>
                        {{ $guest->first_name }} {{ $guest->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Room</label>
            <select name="room_id" class="form-select" required>
                <option value="">Select Room</option>

                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}"
                        {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                        Room {{ $room->room_number }}
                        - {{ $room->roomType->name }}
                        - ₱{{ number_format($room->price_per_night, 2) }}/night
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Check-in Date</label>
            <input type="date"
                   name="check_in"
                   class="form-control"
                   value="{{ old('check_in', $reservation->check_in?->format('Y-m-d')) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Check-out Date</label>
            <input type="date"
                   name="check_out"
                   class="form-control"
                   value="{{ old('check_out', $reservation->check_out?->format('Y-m-d')) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Amount (₱)</label>
            <input type="number"
                   name="total_amount"
                   class="form-control"
                   value="{{ old('total_amount', $reservation->total_amount) }}"
                   min="0"
                   step="0.01"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending"
                    {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="confirmed"
                    {{ old('status', $reservation->status) == 'confirmed' ? 'selected' : '' }}>
                    Confirmed
                </option>
                <option value="cancelled"
                    {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>
                <option value="completed"
                    {{ old('status', $reservation->status) == 'completed' ? 'selected' : '' }}>
                    Completed
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Update Reservation
        </button>

        <a href="{{ route('reservations.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
