<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;

Route::get('/', [DeviceController::class, 'overview'])->name('overview');

Route::get('/devices', function () {
    return view('index');
})->name('devices.index');

Route::get('/user', function () {
    return view('user');
})->name('user.profile');

Route::resource('devices', DeviceController::class);
