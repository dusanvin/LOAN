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

    public function overview()
    {
        $devices = Device::all();
        return view('overview', compact('devices'));
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
            if ($device->image) {
                Storage::delete('public/' . $device->image);
            }
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