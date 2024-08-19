<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('devices.overview');
    } else {
        return view('auth.login');
    }
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/devices/overview', [DeviceController::class, 'overview'])->name('devices.overview');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('devices', DeviceController::class);
    Route::post('/devices/loan', [DeviceController::class, 'loan'])->name('devices.loan');
    Route::post('/devices/return', [DeviceController::class, 'return'])->name('devices.return');

    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}/reserve', [RoomController::class, 'reserve'])->name('rooms.reserve');
    Route::post('/rooms/{room}/reserve', [RoomController::class, 'storeReservation'])->name('rooms.storeReservation');

    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::patch('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/reservations', [RoomController::class, 'reservations'])->name('reservations.index');
    Route::delete('/reservations/{reservation}', [RoomController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::get('/reservations/{reservation}/edit', [RoomController::class, 'editReservation'])->name('reservations.edit');
    Route::patch('/reservations/{reservation}', [RoomController::class, 'updateReservation'])->name('reservations.update');
    Route::get('/reservations/archived', [RoomController::class, 'archived'])->name('reservations.archived');



});

// Administratoren können Räume erstellen, bearbeiten und löschen
Route::middleware(['auth', 'role:administration'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/log', [DeviceController::class, 'log'])->name('devices.log');
});

require __DIR__.'/auth.php';
