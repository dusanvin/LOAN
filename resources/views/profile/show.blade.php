@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Profil</h1>
    <div class="mb-8">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Rolle:</strong> {{ $user->role }}</p>
    </div>
@endsection
