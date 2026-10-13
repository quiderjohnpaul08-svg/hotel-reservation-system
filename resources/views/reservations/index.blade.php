
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Reservations</h2>

        <a href="{{ route('reservations.create') }}"
           class="btn btn-primary">
            Add Reservation
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
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>

                        <td>
                            {{ $reservation->guest->first_name }}
                            {{ $reservation->guest->last_name }}
                        </td>

                        <td>{{ $reservation->room->room_number }}</td>

                        <td>{{ $reservation->check_in }}</td>
                        <td>{{ $reservation->check_out }}</td>

                        <td>
                            ₱{{ number_format($reservation->total_amount, 2) }}
                        </td>

                        <td>{{ ucfirst($reservation->status) }}</td>

                        <td class="text-center">
                            <a href="{{ route('reservations.show', $reservation) }}"
                               class="btn btn-info btn-sm">
                                View
                            </a>

                            <a href="{{ route('reservations.edit', $reservation) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('reservations.destroy', $reservation) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this reservation?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No reservations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reservations->links() }}
</div>
@endsection
