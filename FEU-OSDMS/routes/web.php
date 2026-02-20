<?php

use App\Http\Controllers\AssetMatchingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GateEntryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\ViolationReportController;
use Illuminate\Support\Facades\Route;

// 1. ROOT REDIRECT
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// 2. AUTHENTICATED SYSTEM ROUTES
Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- INTELLITHINGS MODULE (Asset Management & AI Matching) ---
    // Custom workflow routes MUST go above the resource
    Route::post('assets/{id}/compare', [AssetMatchingController::class, 'compare'])->name('assets.compare');
    Route::post('assets/{id}/confirm', [AssetMatchingController::class, 'confirmMatch'])->name('assets.confirm');

    // Resource handles: index, create, store, show, edit, update, destroy
    Route::resource('assets', AssetMatchingController::class);

    // --- STUDENT PROFILES & SEARCH ---
    Route::get('/students', [StudentProfileController::class, 'index'])->name('students.index');
    Route::get('/students/{student_id}', [StudentProfileController::class, 'show'])->name('students.show');

    // --- VIOLATIONS & ANALYTICS ---
    Route::get('/violations/report', [ViolationReportController::class, 'index'])->name('violations.report');
    Route::get('/violations/create', [ViolationController::class, 'create'])->name('violations.create');
    Route::post('/violations', [ViolationController::class, 'store'])->name('violations.store');

    // --- GATE ENTRY LOG ---
    Route::get('/gate-entry', [GateEntryController::class, 'index'])->name('gate.index');
    Route::post('/gate-entry', [GateEntryController::class, 'store'])->name('gate.store');

    // --- USER ACCOUNT MANAGEMENT ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
