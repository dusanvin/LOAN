<!-- resources/views/overview.blade.php -->
@extends('layouts.app')

@section('title', 'Ausgeliehene Geräte')

@section('content')
    <h1 class="text-2xl mb-4 font-medium">Ausgeliehene Geräte</h1>
    <p class="mb-8 flex items-center text-sm">Eine Übersicht über alle ausgeliehenen Geräte. Bitte trage alle Geräte ein, die sich in der Ausleihe befinden. 
        <a href="{{ route('devices.create') }}" class="hover:underline text-yellow-700 flex items-center pl-1">
            Du möchtest ein ausgeliehenes Gerät verbuchen? Folge mir!
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="18" width="18" class="ml-1">
                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-1.035-6.037.75.75 0 0 1-.354-1Z" clip-rule="evenodd" />
              </svg>              
        </a>
    </p>
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif
    <table class="w-full bg-gray-800 text-white rounded-t-lg">
        <thead>
            <tr>
                <th class="px-4 py-2 border-gray-700">Bild</th>
                <th class="px-4 py-2 border-gray-700">Name</th>
                <th class="px-4 py-2 border-gray-700">Beschreibung</th>
                <th class="px-4 py-2 border-gray-700">Gruppe</th>
                <th class="px-4 py-2 border-gray-700">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
                <tr>
                    <td class="border px-4 py-2 border-gray-700">{{ $device->title }}</td>
                    <td class="border px-4 py-2 border-gray-700">{{ $device->description }}</td>
                    <td class="border px-4 py-2 border-gray-700">
                        @if($device->image)
                            <img src="{{ Storage::url($device->image) }}" alt="{{ $device->title }}" class="w-16 h-16 object-cover">
                        @endif
                    </td>
                    <td class="border px-4 py-2 border-gray-700">
                        <a href="{{ route('devices.edit', $device) }}" class="text-yellow-500 mr-2">Edit</a>
                        <form action="{{ route('devices.destroy', $device) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
