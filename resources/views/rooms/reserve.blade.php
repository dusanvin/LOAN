@extends('layouts.app')

@section('title', 'Raum reservieren')

@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $room->name }} reservieren</h1>

<form action="{{ route('rooms.storeReservation', $room) }}" method="POST">
    @csrf
    <div class="mb-4">
        <label for="start_date" class="block text-gray-700">Startdatum:</label>
        <input type="date" name="start_date" id="start_date" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 rounded w-full py-2 px-3" required>
    </div>

    <div class="mb-4">
        <label for="start_time" class="block text-gray-700">Startzeit:</label>
        <input type="time" name="start_time" id="start_time" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 rounded w-full py-2 px-3" required>
    </div>

    <div class="mb-4">
        <label for="end_date" class="block text-gray-700">Enddatum:</label>
        <input type="date" name="end_date" id="end_date" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 rounded w-full py-2 px-3" required>
    </div>

    <div class="mb-4">
        <label for="end_time" class="block text-gray-700">Endzeit:</label>
        <input type="time" name="end_time" id="end_time" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 rounded w-full py-2 px-3" required>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Reservieren</button>
</form>
@endsection
