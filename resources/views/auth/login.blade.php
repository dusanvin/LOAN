@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <div class="mb-8 text-sm text-center">
            Willkommen bei<a href="{{ route('login') }}" class="hover:underline text-yellow-700 pl-1 mb-1">Lend</a>, dem System zur Geräteausleihe des<a href="https://digillab.uni-augsburg.de" class="hover:underline text-yellow-700 pl-1" target="_blank">Zentrums für digitales Lehren und Lernen (DigiLLab)</a> der<a href="https://uni-augsburg.de" class="hover:underline text-yellow-700 pl-1" target="_blank">Universität Augsburg</a>.
            <div class="flex items-center mt-6 p-4 text-sm text-gray-800 rounded-lg bg-gray-200 dark:bg-gray-800 dark:text-gray-300 text-center" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only mr-2">Info</span>
                <div>
                  Dieser Dienst ist ein System für Mitarbeitende des DigiLLabs.
                </div>
              </div>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-gray-600 hover:bg-gray-800 border-gray-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Login
                </button>
            </div>
        </form>
        <div class="text-xs text-right hover:underline text-yellow-700"><a href="mailto:team@digillab.uni-augsburg.de">Passwort vergessen?</a></div>
    </div>
</div>
@endsection


