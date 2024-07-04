<?php

// app/Http/Controllers/DeviceController.php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('devices.index', compact('devices'));
    }

    public function loan(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'loan_start_date' => 'required|date',
            'loan_end_date' => 'required|date|after_or_equal:loan_start_date',
        ]);

        $device = Device::findOrFail($request->device_id);
        $device->status = 'loaned';
        $device->borrower_name = $request->borrower_name;
        $device->loan_start_date = $request->loan_start_date;
        $device->loan_end_date = $request->loan_end_date;
        $device->save();

        return redirect()->route('devices.index')->with('status', 'Das Gerät wurde erfolgreich verliehen.');
    }

    public function return(Request $request)
    {
        $device = Device::findOrFail($request->device_id);
        $device->status = 'available';
        $device->borrower_name = null;
        $device->loan_start_date = null;
        $device->loan_end_date = null;
        $device->save();

        return redirect()->route('devices.index')->with('status', 'Das Gerät wurde erfolgreich zurückgegeben.');
    }

    // DeviceController.php
    public function overview()
    {
        // Nur Geräte, die ausgeliehen sind, abrufen
        $devices = Device::where('status', 'loaned')->get();
        return view('devices.overview', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'group' => 'required|string|max:255',
        ]);

        $device = new Device;
        $device->title = $request->title;
        $device->description = $request->description;
        $device->group = $request->group;

        if ($request->hasFile('image')) {
            $device->image = $request->file('image')->store('images', 'public');
        }

        $device->save();

        return redirect()->route('devices.index')->with('success', 'Gerät erfolgreich hinzugefügt.');
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'group' => 'required|string|max:255',
        ]);

        $device->title = $request->title;
        $device->description = $request->description;
        $device->group = $request->group;

        if ($request->hasFile('image')) {
            // Lösche das alte Bild
            if ($device->image) {
                Storage::delete('public/' . $device->image);
            }

            // Speichere das neue Bild
            $device->image = $request->file('image')->store('images', 'public');
        }

        $device->save();

        return redirect()->route('devices.index')->with('success', 'Gerät erfolgreich aktualisiert.');
    }

    public function destroy(Device $device)
    {
        if ($device->image) {
            Storage::disk('public')->delete($device->image); // Importierter Storage-Fassadenname
        }

        $device->delete();

        return redirect()->route('devices.index')->with('success', 'Gerät erfolgreich gelöscht.');
    }
}
