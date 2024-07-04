<!-- resources/views/devices/index.blade.php -->
@extends('layouts.app')

@section('title', 'Geräteübersicht')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Geräte</h1>
    <p class="mb-8 flex items-center text-sm">Eine Übersicht über alle verfügbaren Geräte.
        <a href="{{ route('devices.create') }}" class="hover:underline text-yellow-700 flex items-center pl-1">
            Du möchtest dem System ein Gerät hinzufügen? Folge mir!
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="18" width="18" class="ml-1">
                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 0 0-5.304 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
            </svg>
        </a>
    </p>
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
                @foreach($devices as $device)
                @if ($device->borrower_name)
                    <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm">Ausleihende/r</th>
                    @break
                @else
                    <td class="border-b-2 px-4 py-2 border-gray-500 text-xs w-1/4 text-white"></td>
                    @break
                @endif
                @endforeach
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/8 font-medium text-sm"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
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
                    @if ($device->borrower_name)
                        <td class="border-b px-4 py-2 border-gray-600 text-xs text-white">{{ $device->borrower_name }} bis {{ \Carbon\Carbon::parse($device->loan_end_date)->format('d.m.Y') }}</td>
                    @else
                        <td class="border-b px-4 py-2 border-gray-600 text-xs text-white"> </td>
                    @endif
                    <td class="border-b px-4 py-2 border-gray-600 text-sm text-right">
                        <div class="flex justify-end items-center space-x-0">
                            @if ($device->status == 'available')
                                <!-- Verleihen Button -->
                                <button onclick="openLoanModal({{ $device->id }})" class="shadow-md bg-gray-100 hover:bg-white text-gray-800 font-bold py-2 px-4 rounded" style="min-width: 200px;">
                                    Verleihen
                                </button>
                            @else
                                <!-- Zurückgeben Button -->
                                <form id="return-form-{{ $device->id }}" action="{{ route('devices.return') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="device_id" value="{{ $device->id }}">
                                    <button type="button" onclick="confirmReturn({{ $device->id }}, '{{ $device->title }}', '{{ $device->description }}')" class="shadow-md bg-gray-900 hover:bg-black text-white font-bold py-2 px-4 rounded" style="min-width: 200px;">
                                        Zurückgeben
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('devices.edit', $device) }}" class="py-2 pl-6 pr-2 rounded text-white">
                                <svg height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                </svg>
                            </a>
                            <form action="{{ route('devices.destroy', $device) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-2 px-0 rounded text-white" onclick="return confirm('Sind Sie sicher, dass Sie dieses Gerät löschen möchten?')">
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

    <!-- Verleihen Modal -->
    <div id="loanModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Gerät verleihen</h3>
                            <div class="mt-2">
                                <form id="loanForm" action="{{ route('devices.loan') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="device_id" id="device_id">
                                    <div class="mb-4">
                                        <label for="borrower_name" class="block text-gray-700 text-sm font-bold mb-2">Name der Person:</label>
                                        <input type="text" name="borrower_name" id="borrower_name" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="loan_start_date" class="block text-gray-700 text-sm font-bold mb-2">Anfangsdatum:</label>
                                        <input type="date" name="loan_start_date" id="loan_start_date" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="loan_end_date" class="block text-gray-700 text-sm font-bold mb-2">Enddatum:</label>
                                        <input type="date" name="loan_end_date" id="loan_end_date" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="submitLoanForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-base font-medium text-white hover:bg-black sm:ml-3 sm:w-auto sm:text-sm">Verleihen</button>
                    <button type="button" onclick="closeLoanModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-100 text-base font-medium text-black hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Abbrechen</button>
                </div>
            </div>
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

        function openLoanModal(deviceId) {
            document.getElementById('device_id').value = deviceId;
            document.getElementById('loanModal').classList.remove('hidden');
        }

        function closeLoanModal() {
            document.getElementById('loanModal').classList.add('hidden');
        }

        function submitLoanForm() {
            document.getElementById('loanForm').submit();
        }

        function confirmReturn(deviceId, deviceTitle, deviceDescription) {
            const message = `Wurde ${deviceTitle} zurückgegeben und in den entsprechenden Aufbewahrungsort ${deviceDescription} zurückgeräumt?`;
            if (confirm(message)) {
                document.getElementById(`return-form-${deviceId}`).submit();
            }
        }
    </script>
@endsection
