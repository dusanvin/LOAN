@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nutzer hinzufügen</h1>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Passwort</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Passwort bestätigen</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="form-group">
            <label for="role">Rolle</label>
            <select class="form-control" id="role" name="role" required>
                <option value="administration">Administration</option>
                <option value="moderation">Moderation</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Erstellen</button>
    </form>
</div>
@endsection
