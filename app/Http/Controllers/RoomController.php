<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Reservation;

class RoomController extends Controller
{
    // Lädt die Raumübersicht
    public function index()
    {
        $rooms = Room::all(); // Alle Räume laden
        return view('rooms.index', compact('rooms')); // rooms.index.blade.php anzeigen
    }

    // Lädt aktuelle Raumbuchungen
    public function reservations()
    {
        $rooms = Room::all(); // Alle Räume laden
        $reservations = Reservation::with('room', 'user')
            ->where(function ($query) {
                $query->where('end_date', '>', now()->format('Y-m-d'))
                    ->orWhere(function ($query) {
                        $query->where('end_date', '=', now()->format('Y-m-d'))
                            ->where('end_time', '>', now()->format('H:i'));
                    });
            })
            ->get(); // Nur aktuelle Reservierungen laden
    
        return view('reservations.index', compact('rooms', 'reservations')); // reservations/index.blade.php anzeigen
    }

    // Lädt archivierte Raumbuchungen
    public function archived()
    {
        $rooms = Room::all(); // Alle Räume laden
        $reservations = Reservation::with('room', 'user')
            ->where(function ($query) {
                $query->where('end_date', '<', now()->format('Y-m-d'))
                    ->orWhere(function ($query) {
                        $query->where('end_date', '=', now()->format('Y-m-d'))
                            ->where('end_time', '<', now()->format('H:i'));
                    });
            })
            ->get(); // Nur archivierte Reservierungen laden
    
        return view('reservations.archived', compact('rooms', 'reservations')); // reservations/archived.blade.php anzeigen
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
            'new_column' => null,
        ]);

        return redirect()->route('rooms.index')->with('status', 'Raum erfolgreich hinzugefügt!');
    }

    public function reserve(Room $room)
    {
        return view('rooms.reserve', compact('room'));
    }

    public function storeReservation(Request $request, Room $room)
    {
        // Validierung der Eingabedaten
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:100',
        ]);

        try {
            // Reservierung speichern
            Reservation::create([
                'room_id' => $room->id,
                'user_id' => auth()->id(),
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
                'end_date' => $request->end_date,
                'end_time' => $request->end_time,
                'purpose' => $request->purpose,
            ]);

            // Erfolgreiche Reservierung - Weiterleitung zur Übersicht
            return redirect()->route('rooms.index')->with('status', 'Raum erfolgreich reserviert!');
        } catch (\Exception $e) {
            // Fehlerbehandlung - zurück zur vorherigen Seite mit einer Fehlermeldung
            return redirect()->back()->withErrors('Fehler bei der Reservierung: ' . $e->getMessage());
        }
    }
    

    public function cancelReservation(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('status', 'Reservierung erfolgreich aufgehoben!');
    }

    public function editReservation(Reservation $reservation)
    {
        $room = $reservation->room;
        return view('reservations.edit', compact('reservation', 'room'));
    }

    public function updateReservation(Request $request, Reservation $reservation)
    {
        // Validierung der Eingabedaten
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'purpose' => 'required|string|max:100',
        ]);

        try {
            // Reservierung aktualisieren
            $reservation->update([
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
                'end_date' => $request->end_date,
                'end_time' => $request->end_time,
                'purpose' => $request->purpose,
            ]);

            // Erfolgreiche Reservierung - Weiterleitung zur Übersicht
            return redirect()->route('reservations.index')->with('status', 'Reservierung erfolgreich aktualisiert!');
        } catch (\Exception $e) {
            // Fehlerbehandlung - zurück zur vorherigen Seite mit einer Fehlermeldung
            return redirect()->back()->withErrors('Fehler bei der Aktualisierung: ' . $e->getMessage());
        }
    }

}
