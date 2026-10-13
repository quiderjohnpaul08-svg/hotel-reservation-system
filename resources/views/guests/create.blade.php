
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add Guest</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guests.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text"
                   name="first_name"
                   class="form-control"
                   value="{{ old('first_name') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text"
                   name="last_name"
                   class="form-control"
                   value="{{ old('last_name') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="number"
                   name="phone"
                   class="form-control"
                   value="{{ old('phone') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address"
                      class="form-control"
                      rows="3">{{ old('address') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Guest</button>

        <a href="{{ route('guests.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
