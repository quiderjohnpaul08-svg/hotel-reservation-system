
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Room Type Details</h2>

    <div class="card">
        <div class="card-body">
            <p>
                <strong>Name:</strong>
                {{ $roomType->name }}
            </p>

            <p>
                <strong>Description:</strong>
                {{ $roomType->description ?? 'N/A' }}
            </p>

            <a href="{{ route('room-types.edit', $roomType) }}"
               class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('room-types.index') }}"
               class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
