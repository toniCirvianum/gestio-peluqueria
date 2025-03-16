<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', HomeController::class)->name('home')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware("role:admin");

    // Ruta per crear la reserva
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');

    // Ruta per guardar la reserva
    Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');

    // Rutes per actualitzar la reserva
    Route::patch('/reservations/update_calendar', [ReservationController::class, 'updateCalendar'])->name('reservations.updateCalendar'); // Per FullCalendar
    Route::patch('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update'); // Per formulari d'edició

    // Rutes d'edició i eliminació de reserva
    Route::get('/reservations/{id}', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::get('/clients' , [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{id}/edit' , [ClientController::class, 'edit'])->name('clients.edit');
    Route::patch('/clients/{id}' , [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}' , [ClientController::class, 'destroy'])->name('clients.destroy')->middleware("role:admin");
    Route::get('/clients/create' , [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients/store' , [ClientController::class, 'store'])->name('clients.store');

    Route::get('/workers' , [WorkerController::class, 'index'])->name('workers.index')->middleware("role:admin");
    Route::delete('/workers/{id}' , [WorkerController::class, 'destroy'])->name('workers.destroy')->middleware("role:admin");
});

require __DIR__.'/auth.php';
