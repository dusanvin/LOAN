@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">{{ $user->name }}'s Profile</h1>
        <!-- Weitere Profilinformationen hier -->
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Rolle:</strong> {{ $user->role }}</p>

        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="text-blue-500 hover:underline">Edit Profile</a>
        </div>
    </div>
@endsection
