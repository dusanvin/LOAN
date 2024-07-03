<!-- resources/views/devices/create.blade.php -->
@extends('layouts.app')

@section('title', 'Gerät hinzufügen')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Gerät hinzufügen</h1>

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
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titel:</label>
                <input type="text" name="title" id="title" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ old('title') }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Beschreibung:</label>
                <textarea rows="4" name="description" id="description" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Bild:</label>
                <input type="file" name="image" id="image" class="appearance-none rounded w-full py-2 px-0 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="group" class="block text-gray-700 text-sm font-bold mb-2">Gruppe:</label>
                <select name="group" id="group" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                    <option value="Stativ">Stativ</option>
                    <option value="Kamera">Kamera</option>
                    <option value="VR-/AR-Brille">VR-/AR-Brille</option>
                    <option value="Mikrofon">Mikrofon</option>
                    <option value="Videokonferenzsystem">Videokonferenzsystem</option>
                    <option value="Koffer">Koffer</option>
                    <option value="Koffer">Laptop</option>
                    <option value="Koffer">Tablet</option>
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-gray-600 hover:bg-gray-800 border-gray-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Gerät hinzufügen</button>
            </div>
        </form>
    </div>
@endsection
