@extends('layouts.app')

@section('title', 'Archivierte Raumbuchungen')

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
        <a href="{{ route('reservations.index') }}" class="text-yellow-600 hover:underline">Gebuchte Räume</a>
        <span class="mx-2 text-yellow-600">/</span>
        <span class="text-gray-500">Archivierte Raumbuchungen</span>
    </nav>

    <h1 class="text-2xl font-bold mb-4">Archivierte Raumbuchungen</h1>

    <!-- Table with archived reservations -->
    <div class="container mx-auto p-4 bg-gray-600 rounded-tr rounded-b">
        <table class="w-full bg-gray-700 text-white rounded-lg table-fixed text-left">
            <thead>
                <tr>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">#</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">Raum</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-2/12">Raumnutzende</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">Von (Datum & Uhrzeit)</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">Bis (Datum & Uhrzeit)</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-3/12">Zweck</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm text-right w-3/12"></th>
                </tr>
            </thead>
            <tbody id="reservationTableBody">
                @foreach($reservations->sortBy('start_date') as $reservation)
                    <tr class="reservation-row text-gray-300" data-room-id="{{ $reservation->room_id }}">
                        <td class="border-b px-4 py-2 border-gray-600 text-sm">{{ $reservation->id }}</td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm">{{ $reservation->room->name }}</td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm"><strong>{{ $reservation->user->name }}</strong><br><span class="text-xs">{{ $reservation->user->email }}</span></td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm">
                            {{ \Carbon\Carbon::parse($reservation->start_date)->format('d.m.Y') }} 
                            {{ $reservation->start_time ? \Carbon\Carbon::parse($reservation->start_time)->format('H:i') : '09:00' }} Uhr
                        </td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm">
                            {{ \Carbon\Carbon::parse($reservation->end_date)->format('d.m.Y') }} 
                            {{ $reservation->end_time ? \Carbon\Carbon::parse($reservation->end_time)->format('H:i') : '17:00' }} Uhr
                        </td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm">{{ $reservation->purpose }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
