<?php

use App\Http\Controllers\AssetMatchingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // IntelliThings Module
    Route::get('/assets', [AssetMatchingController::class, 'index'])->name('assets.index');
    Route::get('/assets/create', [AssetMatchingController::class, 'create'])->name('assets.create');
    Route::post('/assets', [AssetMatchingController::class, 'store'])->name('assets.store');
    Route::get('/assets/{id}/edit', [AssetMatchingController::class, 'edit'])->name('assets.edit');
    Route::put('/assets/{id}', [AssetMatchingController::class, 'update'])->name('assets.update');
    Route::get('/assets/{id}/compare', [AssetMatchingController::class, 'compare'])->name('assets.compare');

    // Other placeholders
    Route::get('/students', fn() => view('students.index'))->name('students.index');
    Route::get('/gate-entry', fn() => view('gate.index'))->name('gate.index');
});

require __DIR__.'/auth.php';
