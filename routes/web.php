
<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('guests', GuestController::class);
Route::resource('rooms', RoomController::class);
Route::resource('room-types', RoomTypeController::class);
Route::resource('reservations', ReservationController::class);
Route::resource('payments', PaymentController::class);
