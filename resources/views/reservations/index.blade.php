@extends('layouts.app')

@section('title', 'Raumbuchungen')

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
        <span id="current-room-breadcrumb"></span>
    </nav>

    <h1 class="text-2xl font-bold mb-4">Gebuchte Räume</h1>
    <p class="flex items-center text-sm">Eine Übersicht über alle gebuchten Räume. Hast du Fragen bezüglich einer Raumbuchung? <span class="font-semibold ml-1">Kontaktiere bitte die Person, die den Raum gebucht hat.</span></p>
    <!-- Link zu archivierten Buchungen -->
    <p class="mt-1 mb-8 flex items-center text-sm">
        Ein Raum gilt als archiviert, wenn die Buchung in der Vergangenheit liegt.
        <a href="{{ route('reservations.archived') }}" class="ml-1 hover:underline text-yellow-600 flex items-center">
            Möchtest du zu den archivierten Raumbuchungen? Folge mir!
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="18" width="18" class="ml-1">
                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-1.035-6.037.75.75 0 0 1-.354-1Z" clip-rule="evenodd" />
            </svg>
        </a>
        
    </p>

    @if(session('status'))
        <div class="bg-green-400 text-white p-4 font-semibold mb-4 rounded">
            {{ session('status') }}
        </div>
    @endif

    <!-- Tabs for rooms -->
    <div class="container mx-auto flex items-center">
        <!-- First Tab for "Alle" -->
        <button id="tab-" onclick="filterReservations('', 'Alle')" class="tab-button rounded-t p-4 text-sm mr-2 flex items-center bg-gray-600 text-white flex items-center">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-2">
                <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 0 0 3 3h15a3 3 0 0 1-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125ZM12 9.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H12Zm-.75-2.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H12a.75.75 0 0 1-.75-.75ZM6 12.75a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5H6Zm-.75 3.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5H6a.75.75 0 0 1-.75-.75ZM6 6.75a.75.75 0 0 0-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-3A.75.75 0 0 0 9 6.75H6Z" clip-rule="evenodd" />
                <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 0 1-3 0V6.75Z" />
            </svg>
            Alle
        </button>

        <!-- Sort rooms by name before rendering tabs -->
        @foreach($rooms->sortBy('name') as $room)
            <button id="tab-{{ $room->id }}" onclick="filterReservations('{{ $room->id }}', '{{ $room->name }}')" class="tab-button rounded-t p-4 text-sm mr-2 flex items-center hover:text-black text-gray-700 bg-gray-200">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-2">
                    <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                {{ $room->name }}
            </button>
        @endforeach
    </div>

    <div class="container mx-auto p-4 bg-gray-600 rounded-tr rounded-b">
        <table class="w-full bg-gray-700 text-white rounded-lg table-fixed text-left">
            <thead>
                <tr>
                    <th class="border-b-2 px-4 py-2 border-gray-500 font-medium text-sm w-1/12">#</th>
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
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="py-2 pl-6 pr-2 rounded text-white">
                                    <svg height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>
                                </a>
                                <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Möchten Sie diese Reservierung wirklich stornieren?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="shadow-md bg-gray-900 hover:bg-black text-white font-bold py-2 px-4 rounded text-sm">
                                        Stornieren
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        /* Custom styles */
        .tab-button:focus {
            outline: none;
        }

        /* Spezifischer Stil für den aktiven Tab */
        .tab-button.bg-gray-600.text-white:hover {
            color: white; /* Beibehalten der Textfarbe für den aktiven Tab bei Hover */
        }
    </style>

    <script>
        function filterReservations(roomId, roomName) {
            const rows = document.querySelectorAll('.reservation-row');
            const tabs = document.querySelectorAll('.tab-button');
            const breadcrumbNav = document.getElementById('breadcrumb-nav');
            const currentRoomBreadcrumb = document.getElementById('current-room-breadcrumb');

            rows.forEach(row => {
                if (roomId === '' || row.dataset.roomId === roomId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            tabs.forEach(tab => {
                tab.classList.remove('bg-gray-600', 'text-white');
                tab.classList.add('text-gray-700', 'bg-gray-200');
            });

            const activeTab = document.getElementById(`tab-${roomId}` || 'tab-');
            if (activeTab) {
                activeTab.classList.add('bg-gray-600', 'text-white');
                activeTab.classList.remove('text-gray-700', 'bg-gray-200');
            }

            // Update the breadcrumbs
            if (roomId === '') {
                currentRoomBreadcrumb.innerHTML = '';
            } else {
                currentRoomBreadcrumb.innerHTML = `<span class="mx-2 text-yellow-600">/</span><span class="text-gray-500">${roomName}</span>`;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            filterReservations('');
        });
    </script>
@endsection
