
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Guest</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guests.update', $guest) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text"
                   name="first_name"
                   class="form-control"
                   value="{{ old('first_name', $guest->first_name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text"
                   name="last_name"
                   class="form-control"
                   value="{{ old('last_name', $guest->last_name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $guest->email) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="number"
                   name="phone"
                   class="form-control"
                   value="{{ old('phone', $guest->phone) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address"
                      class="form-control"
                      rows="3">{{ old('address', $guest->address) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Guest</button>

        <a href="{{ route('guests.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
