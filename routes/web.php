<?php

use App\Http\Controllers\CargoTripController;
use Illuminate\Support\Facades\Route;

// 1. Публичные маршруты (доступны всем гостям)
Route::get('/', [CargoTripController::class, 'welcome'])->name('welcome');
Route::get('/trips', [CargoTripController::class, 'index'])->name('trips.index');
Route::get('/trips/{cargoTrip}', [CargoTripController::class, 'show'])->name('trips.show');

// 2. Закрытые административные маршруты (доступны только авторизованным диспетчерам)
Route::middleware(['auth'])->group(function () {
    Route::get('/trips/create/new', [CargoTripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [CargoTripController::class, 'store'])->name('trips.store');
    Route::get('/trips/{cargoTrip}/edit', [CargoTripController::class, 'edit'])->name('trips.edit');
    Route::put('/trips/{cargoTrip}', [CargoTripController::class, 'update'])->name('trips.update');
    Route::delete('/trips/{cargoTrip}', [CargoTripController::class, 'destroy'])->name('trips.destroy');
    // Перенаправление со стандартного дашборда Breeze на наш список рейсов
    Route::get('/dashboard', function () {
        return redirect()->route('trips.index');
    })->middleware(['auth'])->name('dashboard');
});

// Стандартные маршруты аутентификации Laravel Breeze
require __DIR__ . '/auth.php';


