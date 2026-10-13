<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    // 1. Display all room types
    public function index()
    {
        $roomTypes = RoomType::latest()->paginate(10);

        return view('room_types.index', compact('roomTypes'));
    }

    // 2. Show the form for adding a room type
    public function create()
    {
        return view('room_types.create');
    }

    // 3. Save the new room type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:room_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        RoomType::create($validated);

        return redirect()
            ->route('room-types.index')
            ->with('success', 'Room type added successfully.');
    }

    // 4. Display one room type
    public function show(RoomType $roomType)
    {
        return view('room_types.show', compact('roomType'));
    }

    // 5. Show the form for editing a room type
    public function edit(RoomType $roomType)
    {
        return view('room_types.edit', compact('roomType'));
    }

    // 6. Update an existing room type
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('room_types', 'name')->ignore($roomType->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $roomType->update($validated);

        return redirect()
            ->route('room-types.index')
            ->with('success', 'Room type updated successfully.');
    }

    // 7. Delete a room type
    public function destroy(RoomType $roomType)
    {
        if ($roomType->rooms()->exists()) {
            return redirect()
                ->route('room-types.index')
                ->with('error', 'Cannot delete this room type because rooms are assigned to it.');
        }

        $roomType->delete();

        return redirect()
            ->route('room-types.index')
            ->with('success', 'Room type deleted successfully.');
    }
}
