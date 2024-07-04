@extends('layouts.app')

@section('title', 'Übersicht')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Geräteübersicht</h1>
    <p class="mb-8 flex items-center text-sm">Eine Übersicht über alle verfügbaren Geräte.
        <a href="{{ route('devices.create') }}" class="hover:underline text-yellow-700 flex items-center pl-1">
            Du möchtest dem System ein Gerät hinzufügen? Folge mir!
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="18" width="18" class="ml-1">
                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-4.5 4.5a3.75 3.75 0 0 0 1.035 6.037.75.75 0 0 1-.646 1.353 5.25 5.25 0 0 1-1.449-8.45l4.5-4.5a5.25 5.25 0 1 1 7.424 7.424l-1.757 1.757a.75.75 0 1 1-1.06-1.06l1.757-1.757a3.75 3.75 0 0 0 0-5.304Zm-7.389 4.267a.75.75 0 0 1 1-.353 5.25 5.25 0 0 1 1.449 8.45l-4.5 4.5a5.25 5.25 0 1 1-7.424-7.424l1.757-1.757a.75.75 0 1 1 1.06 1.06l-1.757 1.757a3.75 3.75 0 1 0 5.304 5.304l4.5-4.5a3.75 3.75 0 0 0-1.035-6.037.75.75 0 0 1-.354-1Z" clip-rule="evenodd" />
            </svg>
        </a>
    </p>
    @if(session('success'))
        <div class="bg-green-400 text-white p-4 font-semibold mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif
    <table class="w-full bg-gray-700 text-white rounded-lg table-fixed text-left">
        <thead>
            <tr>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/8 font-medium text-sm">Bild</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm">Name & Label</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/8 font-medium text-sm">Ort (Schrank/Fach)</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/8 font-medium text-sm">Kategorie</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/8 font-medium text-sm">Status</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
                @php
                    // Definiere die Farbe basierend auf der Gruppe
                    switch ($device->group) {
                        case 'Stativ':
                            $groupColor = 'bg-red-500';
                            break;
                        case 'Kamera':
                            $groupColor = 'bg-blue-500';
                            break;
                        case 'VR-/AR-Brille':
                            $groupColor = 'bg-green-700';
                            break;
                        case 'Mikrofon':
                            $groupColor = 'bg-yellow-700';
                            break;
                        case 'Videokonferenzsystem':
                            $groupColor = 'bg-purple-700';
                            break;
                        case 'Koffer':
                            $groupColor = 'bg-pink-700';
                            break;
                        case 'Laptop':
                            $groupColor = 'bg-indigo-700';
                            break;
                        case 'Tablet':
                            $groupColor = 'bg-black';
                            break;
                        default:
                            $groupColor = 'bg-gray-700';
                            break;
                    }
                @endphp
                <tr>
                <td class="border-b px-4 py-2 border-gray-600">
                        <img src="{{ $device->image ? Storage::url($device->image) : asset('img/filler.png') }}" alt="{{ $device->title }}" class="w-16 h-16 object-cover cursor-pointer rounded border-2 hover:border-gray-400" onclick="openModal('{{ $device->image ? Storage::url($device->image) : asset('img/filler.png') }}')">
                    </td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $device->title }}</td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $device->description }}</td>
                    <td class="border-b px-4 py-2 border-gray-600 text-xs "><span class="text-white {{ $groupColor }} rounded p-2">{{ $device->group }}</span></td>
                    <td class="border-b px-4 py-2 border-gray-600 text-xs">
                        <span class="text-white bg-green-700 rounded p-2 inline-flex">
                            Verfügbar
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="ml-2">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm text-right">
                        <div class="flex justify-end items-center space-x-4">
                            <a href="{{ route('devices.edit', $device) }}" class="py-2 px-4 rounded text-white">
                                <svg height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                </svg>
                            </a>
                            <form action="{{ route('devices.destroy', $device) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-2 px-4 rounded text-white" onclick="return confirm('Sind Sie sicher, dass Sie dieses Gerät löschen möchten?')">
                                    <svg height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
<div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden flex justify-center items-center" onclick="closeModal()">
    <div class="bg-white p-1 rounded-lg relative" onclick="event.stopPropagation()">
        <span class="absolute top-2 right-2 p-2 cursor-pointer text-white" onclick="closeModal()">
            <svg height="36" width="36" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
            </svg>
        </span>
        <img id="modalImage" src="" alt="Image" class="max-w-screen-md max-h-screen-md rounded-lg">
    </div>
</div>

<script>
    function openModal(imageUrl) {
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
</script>

@endsection
