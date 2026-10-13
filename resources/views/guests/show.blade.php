
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Guest Details</h2>

        <a href="{{ route('guests.index') }}" class="btn btn-secondary">
            Back to Guests
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            Guest Information
        </div>

        <div class="card-body">
            <p>
                <strong>Guest ID:</strong>
                {{ $guest->id }}
            </p>

            <p>
                <strong>First Name:</strong>
                {{ $guest->first_name }}
            </p>

            <p>
                <strong>Last Name:</strong>
                {{ $guest->last_name }}
            </p>

            <p>
                <strong>Email:</strong>
                {{ $guest->email }}
            </p>

            <p>
                <strong>Phone:</strong>
                {{ $guest->phone }}
            </p>

            <p>
                <strong>Address:</strong>
                {{ $guest->address ?? 'N/A' }}
            </p>

            <a href="{{ route('guests.edit', $guest) }}"
               class="btn btn-warning">
                Edit Guest
            </a>
        </div>
    </div>
</div>
@endsection
