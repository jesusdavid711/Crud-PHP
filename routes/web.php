<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductosController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'Home'])->name('home');

Route::prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductosController::class, 'index'])->name('index');
    Route::get('/create', [ProductosController::class, 'create'])->name('create');
    Route::post('/', [ProductosController::class, 'store'])->name('store');
    Route::get('/{id}', [ProductosController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ProductosController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductosController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductosController::class, 'remove'])->name('remove');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
