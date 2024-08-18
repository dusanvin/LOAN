<!-- resources/views/devices/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Gerät bearbeiten')

@section('content')

<!-- Breadcrumbs -->
<nav id="breadcrumb-nav" class="flex text-sm mb-8" aria-label="Breadcrumb">
    <a href="{{ url('/') }}" class="text-yellow-600 hover:underline flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-1">
            <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
            <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
        </svg>
    </a>
    <span class="mx-2 text-yellow-600">/</span>
    <a href="{{ route('devices.index') }}" class="text-yellow-600 hover:underline">Geräte</a>
    <span class="mx-2 text-yellow-600">/</span>
    <span class="text-gray-500"><strong>{{ old('title', $device->title) }}</strong> bearbeiten</span>
</nav>

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
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Name & Label inkl. Seriennummer (SN) (z.B. <em>HTC VIVE Pro 2 #1 (SN: 82682630)</em>):</label>
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
                <option value="Sonstiges" {{ $device->group == 'Sonstiges' ? 'selected' : '' }}>Sonstiges</option>
            </select>
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-gray-600 hover:bg-gray-800 border-gray-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Gerät aktualisieren</button>
        </div>
    </form>
</div>
@endsection
