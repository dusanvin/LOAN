@extends('layouts.app')

@section('title', 'Nutzerübersicht')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nutzer</h1>
    <p class="mb-8 flex items-center text-sm">Eine Übersicht über alle registrierten Nutzer.
        <a href="{{ route('users.create') }}" class="hover:underline text-yellow-700 flex items-center pl-1">
            Möchten Sie einen neuen Nutzer hinzufügen? Folge mir!
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
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm">Name</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm">E-Mail-Adresse</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm">Rolle</th>
                <th class="border-b-2 px-4 py-2 border-gray-500 w-1/4 font-medium text-sm">Verifikationsdatum</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $user->name }}</td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $user->email }}</td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $user->role }}</td>
                    <td class="border-b px-4 py-2 border-gray-600 text-sm break-words">{{ $user->email_verified_at ? $user->email_verified_at->format('d.m.Y H:i') : 'Nicht verifiziert' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
