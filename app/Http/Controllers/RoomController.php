<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; // Wenn es ein Room Modell gibt
use App\Models\Reservation; // Wenn es ein Reservation Modell gibt

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all(); // Alle Räume laden
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('status', 'Raum erfolgreich aktualisiert!');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('status', 'Raum erfolgreich gelöscht!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Room::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'new_column' => null,  // Korrekte Zuweisung von NULL
        ]);             

        return redirect()->route('rooms.index')->with('status', 'Raum erfolgreich hinzugefügt!');
    }

    public function reserve(Room $room)
    {
        return view('rooms.reserve', compact('room'));
    }

    public function storeReservation(Request $request, Room $room)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Reservierung speichern
        $reservation = new Reservation();
        $reservation->room_id = $room->id;
        $reservation->user_id = auth()->id();
        $reservation->start_date = $request->start_date;
        $reservation->end_date = $request->end_date;
        $reservation->save();

        return redirect()->route('rooms.index')->with('status', 'Raum erfolgreich reserviert!');
    }

    public function reservations()
    {
        $rooms = Room::all(); // Lade alle Räume
        $reservations = Reservation::with('room', 'user')->get(); // Lade alle Reservierungen mit zugehörigen Raum- und Benutzerdaten
    
        return view('reservations.index', compact('rooms', 'reservations'));
    }    

    public function cancelReservation(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('status', 'Reservierung erfolgreich aufgehoben!');
    }

}
