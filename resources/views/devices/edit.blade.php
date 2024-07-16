<!-- resources/views/devices/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Gerät bearbeiten')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Gerät bearbeiten</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('devices.update', $device) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">ame & Label inkl. Seriennummer (SN) (z.B. <em>HTC VIVE Pro 2 #1 (SN: 82682630)</em>):</label>
                <input type="text" name="title" id="title" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ old('title', $device->title) }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Beschreibung (Aufbewahrungsort wie Schranknummer/Fach, z.B. <em>1/F</em>):</label>
                <textarea rows="4" name="description" id="description" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight">{{ old('description', $device->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Bild:</label>
                @if ($device->image)
                    <div class="mt-2">
                        <img src="{{ Storage::url($device->image) }}" alt="{{ $device->title }}" class="w-16 h-16 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="appearance-none rounded w-full py-2 px-0 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="group" class="block text-gray-700 text-sm font-bold mb-2">Kategorie:</label>
                <select name="group" id="group" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                    <option value="Stativ" {{ $device->group == 'Stativ' ? 'selected' : '' }}>Stativ</option>
                    <option value="Kamera" {{ $device->group == 'Kamera' ? 'selected' : '' }}>Kamera</option>
                    <option value="VRAR" {{ $device->group == 'VRAR' ? 'selected' : '' }}>VR-/AR-Brille</option>
                    <option value="Mikrofon" {{ $device->group == 'Mikrofon' ? 'selected' : '' }}>Mikrofon</option>
                    <option value="Videokonferenzsystem" {{ $device->group == 'Videokonferenzsystem' ? 'selected' : '' }}>Videokonferenzsystem</option>
                    <option value="Koffer" {{ $device->group == 'Koffer' ? 'selected' : '' }}>Koffer</option>
                    <option value="Laptop" {{ $device->group == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                    <option value="Tablet" {{ $device->group == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-gray-600 hover:bg-gray-800 border-gray-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Gerät aktualisieren</button>
            </div>
        </form>
    </div>
@endsection
