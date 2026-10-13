<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::latest()->paginate(10);

        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:guests,email'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        Guest::create($validated);

        return redirect()
            ->route('guests.index')
            ->with('success', 'Guest added successfully.');
    }

    public function show(Guest $guest)
    {
        $guest->load('reservations.room.roomType');

        return view('guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('guests', 'email')->ignore($guest->id),
            ],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $guest->update($validated);

        return redirect()
            ->route('guests.index')
            ->with('success', 'Guest updated successfully.');
    }

    public function destroy(Guest $guest)
    {
        if ($guest->reservations()->exists()) {
            return redirect()
                ->route('guests.index')
                ->with('error', 'Cannot delete a guest with reservations.');
        }

        $guest->delete();

        return redirect()
            ->route('guests.index')
            ->with('success', 'Guest deleted successfully.');
    }
}
