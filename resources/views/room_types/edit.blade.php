
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Room Type</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('room-types.update', $roomType) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Room Type Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $roomType->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                      class="form-control"
                      rows="3">{{ old('description', $roomType->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>

        <a href="{{ route('room-types.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
