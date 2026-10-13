
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Room</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rooms.update', $room) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Room Number</label>
            <input type="text"
                   name="room_number"
                   class="form-control"
                   value="{{ old('room_number', $room->room_number) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select name="room_type_id" class="form-select" required>
                <option value="">Select Room Type</option>

                @foreach ($roomTypes as $roomType)
                    <option value="{{ $roomType->id }}"
                        {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                        {{ $roomType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Price per Night (₱)</label>
            <input type="number"
                   name="price_per_night"
                   class="form-control"
                   value="{{ old('price_per_night', $room->price_per_night) }}"
                   min="0.01"
                   step="0.01"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="available"
                    {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>
                    Available
                </option>
                <option value="unavailable"
                    {{ old('status', $room->status) == 'unavailable' ? 'selected' : '' }}>
                    Unavailable
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Room</button>

        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
