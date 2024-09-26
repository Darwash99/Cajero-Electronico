<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\HistorialController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/tareas', TareasController::class);
    //Route::resource('/historial', HistorialController::class);
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::post('/historial', [HistorialController::class, 'store'])->name('historial.store');
    Route::get('/historial/reporte', [HistorialController::class, 'generarreporte'])->name('historial.generarreporte');
});

require __DIR__.'/auth.php';
