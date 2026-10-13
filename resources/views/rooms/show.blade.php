
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Room Details</h2>

        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
            Back to Rooms
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            Room Information
        </div>

        <div class="card-body">
            <p>
                <strong>Room ID:</strong>
                {{ $room->id }}
            </p>

            <p>
                <strong>Room Number:</strong>
                {{ $room->room_number }}
            </p>

            <p>
                <strong>Room Type:</strong>
                {{ $room->roomType->name }}
            </p>

            <p>
                <strong>Price per Night:</strong>
                ₱{{ number_format($room->price_per_night, 2) }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ ucfirst($room->status) }}
            </p>

            <a href="{{ route('rooms.edit', $room) }}"
               class="btn btn-warning">
                Edit Room
            </a>
        </div>
    </div>
</div>
@endsection
