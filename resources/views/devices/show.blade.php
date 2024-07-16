@extends('layouts.app')

@section('title', $device->title)

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ $device->title }}</h1>

    <!-- Tabs for details and history -->
    <div class="container mx-auto flex items-center">
        <button id="tab-Gerätespezifika" onclick="showTab('Gerätespezifika')" class="tab-button rounded-t p-4 text-sm mr-2 flex items-center bg-gray-600 text-white">
            Gerätespezifika
        </button>
        <button id="tab-Historie" onclick="showTab('Historie')" class="tab-button rounded-t p-4 text-sm mr-2 flex items-center text-gray-700 bg-gray-200">
            Historie
        </button>
    </div>

    <div class="container mx-auto mb-8 p-4 bg-gray-600 rounded-tr rounded-b">
        <div id="Gerätespezifika" class="tab-content">
            <div class="flex">
                <div class="w-1/4">
                    <img src="{{ $device->image ? Storage::url($device->image) : asset('img/filler.png') }}" alt="{{ $device->title }}" class="w-full h-auto object-cover cursor-pointer rounded border-2 hover:border-gray-400" onclick="openImageModal('{{ $device->image ? Storage::url($device->image) : asset('img/filler.png') }}')">
                </div>
                <div class="w-3/4 pl-4">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-300 text-sm font-semibold mb-2">Name & Label inkl. Seriennummer (SN):</label>
                        <input type="text" name="title" id="title" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ $device->title }}" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-300 text-sm  font-semibold mb-2">Beschreibung (z.B. Aufbewahrungsort):</label>
                        <textarea rows="2" name="description" id="description" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight" disabled>{{ $device->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="group" class="block text-gray-300 text-sm  font-semibold mb-2">Kategorie:</label>
                        <select name="group" id="group" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" disabled>
                            <option value="Stativ" {{ $device->group == 'Stativ' ? 'selected' : '' }}>Stativ</option>
                            <option value="Kamera" {{ $device->group == 'Kamera' ? 'selected' : '' }}>Kamera</option>
                            <option value="VRAR" {{ $device->group == 'VRAR' ? 'selected' : '' }}>VR-/AR-Brille</option>
                            <option value="Mikrofon" {{ $device->group == 'Mikrofon' ? 'selected' : '' }}>Mikrofon</option>
                            <option value="Videokonferenzsystem" {{ $device->group == 'Videokonferenzsystem' ? 'selected' : '' }}>Videokonferenzsystem</option>
                            <option value="Koffer" {{ $device->group == 'Koffer' ? 'selected' : '' }}>Koffer</option>
                            <option value="Laptop" {{ $device->group == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Tablet" {{ $device->group == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-300 text-sm  font-semibold mb-2">Status:</label>
                        <span class="text-white {{ $device->status == 'available' ? 'bg-green-600' : 'bg-yellow-600' }} rounded p-2 inline-flex">
                            {{ $device->status == 'available' ? 'Verfügbar' : 'Verliehen' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div id="Historie" class="tab-content hidden">
            <div class="bg-black text-white p-4 rounded">
                @foreach ($histories as $history)
                <p class="text-sm">
                    <span class="text-gray-400">{{ \Carbon\Carbon::parse($history->created_at)->format('d.m.Y H:i') }}: </span>
                    <span class="text-green-400">
                        {{ $history->action === 'loaned' ? 'Geliehen von' : 'Entgegengenommen und eingetragen durch' }}
                    </span> 
                    <span class="text-yellow-400">{{ $history->user_name }}</span>
                    (verliehen von <span class="text-blue-400">{{ $history->action_by }}</span>)
                </p>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal for image -->
    <div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden flex justify-center items-center z-10" onclick="closeImageModal()">
        <div class="bg-white p-1 rounded-lg relative" onclick="event.stopPropagation()">
            <span class="absolute top-2 right-2 p-2 cursor-pointer text-white" onclick="closeImageModal()">
                <svg height="36" width="36" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                </svg>
            </span>
            <img id="modalImage" src="" alt="Image" class="max-w-screen-md max-h-screen-md rounded-lg">
        </div>
    </div>

</div>

<style>
    .tab-button:focus {
        outline: none;
    }
</style>

<script>
    function openImageModal(imageUrl) {
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    function showTab(tabName) {
        const tabs = document.querySelectorAll('.tab-content');
        const tabButtons = document.querySelectorAll('.tab-button');

        tabs.forEach(tab => {
            tab.classList.add('hidden');
        });

        tabButtons.forEach(button => {
            button.classList.remove('bg-gray-600', 'text-gray-300');
            button.classList.add('text-gray-700', 'bg-gray-200');
            button.classList.add('hover:text-gray-900'); // Add hover effect
        });

        document.getElementById(tabName).classList.remove('hidden');
        const activeTabButton = document.getElementById('tab-' + tabName);
        activeTabButton.classList.add('bg-gray-600', 'text-gray-300');
        activeTabButton.classList.remove('text-gray-700', 'hover:text-gray-900'); // Remove hover effect from active tab
    }

    document.addEventListener('DOMContentLoaded', () => {
        showTab('Gerätespezifika');
    });
</script>

@endsection
