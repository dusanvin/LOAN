@extends('layouts.app')

@section('title', 'Neuen Raum hinzufügen')

@section('content')
    <div class="container mx-auto">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="text-yellow-600 hover:underline flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-1">
                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                </svg>
            </a>
            <span class="mx-2 text-yellow-600">/</span>
            <a href="{{ route('rooms.index') }}" class="text-yellow-600 hover:underline">Räume</a>
            <span class="mx-2 text-yellow-600">/</span>
            <span class="text-gray-500">Neuen Raum hinzufügen</span>
        </nav>
        <h1 class="text-2xl font-bold mb-4">Neuen Raum hinzufügen</h1>

        <!-- Anzeige der Validierungsfehler -->
        @if($errors->any())
            <div class="bg-red-500 text-white p-2 mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.store') }}" method="POST" class="w-full">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name des Raums:</label>
                <input type="text" name="name" id="name" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required maxlength="255" value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Beschreibung:</label>
                <textarea name="description" id="description" rows="4" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight" required maxlength="255">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Standort:</label>
                <input type="text" name="location" id="location" class="bg-gray-50 focus:ring-gray-500 focus:border-gray-500 border-gray-300 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required maxlength="255" value="{{ old('location') }}">
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-gray-600 hover:bg-gray-800 border-gray-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Raum hinzufügen</button>
            </div>
        </form>
    </div>
@endsection
