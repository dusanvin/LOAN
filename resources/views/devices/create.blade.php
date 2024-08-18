<!-- resources/views/devices/create.blade.php -->
@extends('layouts.app')

@section('title', 'Gerät hinzufügen')

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
    <span class="text-gray-500">Gerät hinzufügen</span>
</nav>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Gerät hinzufügen</h1>
    <p class="mb-8 flex items-center text-sm">Füge dem System ein neues Gerät hinzu.
        <a href="{{ route('devices.index') }}" class="hover:underline text-yellow-600 flex items-center pl-1">
            Du möchtest zur Geräteübersicht? Folge mir!
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="18" width="18" class="ml-1">
                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-1.035-6.037.75.75 0 0 1-.354-1Z" clip-rule="evenodd" />
            </svg>
        </a>
    </p>
    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('devices.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Name & Label inkl. Seriennummer (SN) (z.B. <em>HTC VIVE Pro 2 #1 (SN: 82682630)</em>):</label>
            <input type="text" name="title" id="title" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ old('title') }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Beschreibung (Aufbewahrungsort wie Schranknummer/Fach, z.B. <em>1/F</em>):</label>
            <textarea rows="4" name="description" id="description" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Bild (*.jpg/*.jpeg/*.webm etc.):</label>
            <input type="file" name="image" id="image" class="appearance-none rounded w-full py-2 px-0 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="group" class="block text-gray-700 text-sm font-bold mb-2">Kategorie:</label>
            <select name="group" id="group" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                <option value="Stativ">Stativ</option>
                <option value="Kamera">Kamera</option>
                <option value="VRAR">VR-/AR-Brille</option>
                <option value="Mikrofon">Mikrofon</option>
                <option value="Videokonferenzsystem">Videokonferenzsystem</option>
                <option value="Koffer">Koffer</option>
                <option value="Laptop">Laptop</option>
                <option value="Tablet">Tablet</option>
                <option value="Microcontroller">Microcontroller</option>
                <option value="Sonstiges">Sonstiges</option>
            </select>
        </div>
        <div class="mb-4">
            <button type="submit" class="bg-gray-600 hover:bg-gray-800 border-gray-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Gerät hinzufügen</button>
        </div>
    </form>
</div>
@endsection
