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
    <p class="flex items-center text-sm">Eine Übersicht über alle archivierten Raumbuchungen. Hast du Fragen bezüglich einer Raumbuchung? <span class="font-semibold ml-1">Kontaktiere bitte die Person, die den Raum gebucht hat.</span></p>
    <!-- Link zu archivierten Buchungen -->
    <p class="mt-1 mb-8 flex items-center text-sm">
        Ein Raum gilt als archiviert, wenn die Buchung in der Vergangenheit liegt.
        <a href="{{ route('reservations.index') }}" class="ml-1 hover:underline text-yellow-600 flex items-center">
            Möchtest du zu den aktuellen Raumbuchungen? Folge mir!
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="18" width="18" class="ml-1">
                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-1.035-6.037.75.75 0 0 1-.354-1Z" clip-rule="evenodd" />
            </svg>
        </a>
        
    </p>
    <!-- Table with archived reservations -->
    <div class="container mx-auto p-4 bg-gray-600 rounded">
        <table class="w-full bg-gray-700 text-white rounded-lg table-fixed text-left">
            <thead>
                <tr>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">Buchung</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">Raum</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-2/12">Raumnutzende</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">Beginn</th>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">Ende</th>
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
                        <td class="border-b px-4 py-2 border-gray-600 text-right">
                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-2 px-0 rounded text-white" onclick="return confirm('Sind Sie sicher, dass Sie diese Buchung endgültig löschen möchten?')">
                                    <svg height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
