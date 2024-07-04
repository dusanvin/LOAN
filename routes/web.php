<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    if (Auth::check()) {
        // Benutzer ist authentifiziert
        return redirect()->route('devices.overview'); // Ersetze 'dashboard' durch deine gewünschte Route
    } else {
        // Benutzer ist ein Gast
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
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('devices', DeviceController::class);
    Route::post('/devices/loan', [DeviceController::class, 'loan'])->name('devices.loan');
    Route::post('/devices/return', [DeviceController::class, 'return'])->name('devices.return');


});

Route::middleware(['auth', 'role:administration'])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'create', 'store']);
    Route::get('/log', [DeviceController::class, 'log'])->name('devices.log'); // Assuming you have a method for logs
});

require __DIR__.'/auth.php';
