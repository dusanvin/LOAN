<!-- resources/views/devices/overview.blade.php -->
@extends('layouts.app')

@section('title', 'Übersicht der ausgeliehenen Geräte')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Ausgeliehene Geräte</h1>
    <p class="mb-8 flex items-center text-sm">Eine Übersicht über alle ausgeliehenen Geräte.</p>
    @if(session('status'))
        <div class="bg-green-400 text-white p-4 font-semibold mb-4 rounded">
            {{ session('status') }}
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
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm">Ausleihende/r</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/8 font-medium text-sm"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
                @if ($device->status == 'loaned')
                    <tr>
                        <td class="border-b px-4 py-2 border-gray-600">
                            <img src="{{ $device->image ? Storage::url($device->image) : asset('img/filler.png') }}" alt="{{ $device->title }}" class="w-16 h-16 object-cover cursor-pointer rounded border-2 hover:border-gray-400" onclick="openImageModal('{{ $device->image ? Storage::url($device->image) : asset('img/filler.png') }}')">
                        </td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $device->title }}</td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $device->description }}</td>
                        <td class="border-b px-4 py-2 border-gray-600 text-xs "><span class="text-white rounded p-2">{{ $device->group }}</span></td>
                        <td class="border-b px-4 py-2 border-gray-600 text-xs">
                            <span class="text-white {{ $device->status == 'available' ? 'bg-green-600' : 'bg-yellow-600' }} rounded p-2 inline-flex">
                                {{ $device->status == 'available' ? 'Verfügbar' : 'Verliehen' }}
                            </span>
                        </td>
                        <td class="border-b px-4 py-2 border-gray-600 text-xs text-white">{{ $device->borrower_name }} von {{ \Carbon\Carbon::parse($device->loan_start_date)->format('d.m.Y') }} bis {{ \Carbon\Carbon::parse($device->loan_end_date)->format('d.m.Y') }}</td>
                        <td class="border-b px-4 py-2 border-gray-600 text-sm text-right">
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
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

    <script>
        function openImageModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        function confirmReturn(deviceId, deviceTitle, deviceDescription) {
            const message = `Wurde ${deviceTitle} zurückgegeben und in den entsprechenden Aufbewahrungsort ${deviceDescription} zurückgeräumt?`;
            if (confirm(message)) {
                document.getElementById(`return-form-${deviceId}`).submit();
            }
        }
    </script>
@endsection
