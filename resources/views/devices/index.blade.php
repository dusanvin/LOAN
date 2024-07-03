<!-- resources/views/devices/index.blade.php -->
@extends('layouts.app')

@section('title', 'Geräteübersicht')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Übersicht</h1>
    @if(session('success'))
        <div class="bg-green-400 text-white p-4 font-semibold mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif
    <table class="w-full bg-gray-800 text-white rounded-lg table-fixed text-left">
        <thead>
            <tr class="">
                <th class="border-b-4 px-4 py-2 border-gray-500 w-1/8 font-medium">Bild</th>
                <th class="border-b-4 px-4 py-2 border-gray-500 w-1/8 font-medium">Name</th>
                <th class="border-b-4 px-4 py-2 border-gray-500 w-1/4 font-medium">Beschreibung</th>
                <th class="border-b-4 px-4 py-2 border-gray-500 w-1/4 font-medium">Gruppe</th>
                <th class="border-b-4 px-4 py-2 border-gray-500 w-1/4 font-medium"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
                <tr>
                    <td class="border-b-1 px-4 py-2 border-gray-700">
                        @if($device->image)
                            <img src="{{ Storage::url($device->image) }}" alt="{{ $device->title }}" class="w-24 h-24 object-cover cursor-pointer rounded" onclick="openModal('{{ Storage::url($device->image) }}')">
                        @endif
                    </td>
                    <td class="border-b-1 px-4 py-2 border-gray-700 text-sm break-words">{{ $device->title }}</td>
                    <td class="border-b-1 px-4 py-2 border-gray-700 text-sm break-words">{{ $device->description }}</td>
                    <td class="border-b-1 px-4 py-2 border-gray-700 text-sm"><span class="text-black bg-gray-300 rounded p-2">{{ $device->group }}</span></td>
                    <td class="border-b-1 px-4 py-2 border-gray-700  text-sm text-right">
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
