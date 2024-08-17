@extends('layouts.app')

@section('title', 'Neuen Raum hinzufügen')

@section('content')
<h1 class="text-2xl font-bold mb-4">Neuen Raum hinzufügen</h1>

<!-- Anzeige der Validierungsfehler -->
@if($errors->any())
    <div class="bg-red-400 text-white p-4 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('rooms.store') }}" method="POST">
    @csrf
    <div class="mb-4">
        <label for="name" class="block text-gray-700">Name des Raums:</label>
        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 rounded w-full py-2 px-3" required maxlength="255">
    </div>

    <div class="mb-4">
        <label for="description" class="block text-gray-700">Beschreibung:</label>
        <textarea name="description" id="description" class="bg-gray-50 border border-gray-300 rounded w-full py-2 px-3" rows="4" required maxlength="255"></textarea>
    </div>

    <div class="mb-4">
        <label for="location" class="block text-gray-700">Standort:</label>
        <input type="text" name="location" id="location" class="bg-gray-50 border border-gray-300 rounded w-full py-2 px-3" required maxlength="255">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Raum hinzufügen</button>
</form>
@endsection
