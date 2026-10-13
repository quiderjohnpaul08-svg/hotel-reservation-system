
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Rooms</h2>

        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            Add Room
        </a>
    </div>

    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Price per Night</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($rooms as $room)
                    <tr>
                        <td>{{ $room->id }}</td>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->roomType->name }}</td>
                        <td>₱{{ number_format($room->price_per_night, 2) }}</td>
                        <td>
                            <span class="badge
                                {{ $room->status === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('rooms.show', $room) }}"
                               class="btn btn-info btn-sm">
                                View
                            </a>

                            <a href="{{ route('rooms.edit', $room) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('rooms.destroy', $room) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this room?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No rooms found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $rooms->links() }}
</div>
@endsection
