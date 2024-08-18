@extends('layouts.app')

@section('title', 'Räumeübersicht')

@section('content')
<!-- Breadcrumbs -->
<nav class="flex text-sm mb-8" aria-label="Breadcrumb">
    <a href="{{ url('/') }}" class="text-yellow-600 hover:underline flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-1">
            <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
            <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
        </svg>
    </a>
    <span class="mx-2 text-yellow-600">/</span>
    <span class="text-gray-500">Räume</span>
</nav>
<h1 class="text-2xl font-bold mb-4">Räume</h1>
<p class="flex items-center text-sm">Eine Übersicht über alle Räume. Möchtest du einen <span class="font-semibold mx-1">Raum reservieren?</span> Klicke in der entsprechenden Spalte auf den Button <span class="mx-1 bg-blackshadow-md bg-gray-100 text-gray-800 font-bold py-2 px-4 rounded">Reservieren</span><p>
<p class="mb-8 flex items-center text-sm">
    <a href="{{ route('rooms.create') }}" class="hover:underline text-yellow-600 flex items-center">
    Du möchtest dem System einen Raum hinzufügen? Folge mir!
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="18" width="18" class="ml-1">
            <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-1.035-6.037.75.75 0 0 1-.354-1Z" clip-rule="evenodd" />
        </svg>
    </a>
</p>
@if(session('status'))
<div class="bg-green-400 text-white p-4 font-semibold mb-4 rounded" style="display: block !important;">
    {{ session('status') }}
</div>
@endif

<!-- Raumliste -->
<div class="container mx-auto flex items-center mb-8 p-4 pt-8 bg-gray-600 rounded-tr rounded-b">
    <table class="w-full bg-gray-700 text-white rounded-lg table-fixed text-left">
        <thead>
            <tr>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/12 font-medium text-sm">Name</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-3/12 font-medium text-sm">Standort</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-5/12 font-medium text-sm">Beschreibung</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-3/12 font-medium text-sm"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
                <tr>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">
                        <span class="text-gray-300">{{ $room->name }}</span>
                    </td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">
                        <span class="text-gray-300 text-sm">{{ $room->location }}</span>
                    </td>
                    <td class="border-b px-4 py-2 border-gray-600 break-words text-gray-300 text-sm">{{ $room->description }}</td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm text-right">
                        <div class="flex justify-end items-center space-x-2">
                            <a href="{{ route('rooms.reserve', $room) }}" class="shadow-md bg-gray-100 hover:bg-white text-gray-800 font-bold py-2 px-4 rounded">
                                Reservieren
                            </a>
                                <a href="{{ route('rooms.edit', $room) }}" class="shadow-md bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                    Bearbeiten
                                </a>
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="shadow-md bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Sind Sie sicher, dass Sie diesen Raum löschen möchten?')">
                                        Löschen
                                    </button>
                                </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
