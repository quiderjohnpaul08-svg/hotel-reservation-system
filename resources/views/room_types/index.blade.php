
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Room Types</h2>

        <a href="{{ route('room-types.create') }}"
           class="btn btn-primary">
            Add Room Type
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

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($roomTypes as $roomType)
                <tr>
                    <td>{{ $roomType->id }}</td>
                    <td>{{ $roomType->name }}</td>
                    <td>{{ $roomType->description ?? 'N/A' }}</td>
                    <td class="text-center">
                        <a href="{{ route('room-types.show', $roomType) }}"
                           class="btn btn-info btn-sm">
                            View
                        </a>

                        <a href="{{ route('room-types.edit', $roomType) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('room-types.destroy', $roomType) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this room type?')">
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
                    <td colspan="4" class="text-center">
                        No room types found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $roomTypes->links() }}
</div>
@endsection
