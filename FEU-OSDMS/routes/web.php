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
    Route::get('/assets/id-recovery', [AssetMatchingController::class, 'lostIds'])->name('assets.lost-ids');
    Route::get('/assets/id-recovery/create', [AssetMatchingController::class, 'createId'])->name('assets.create-id');
    Route::post('/assets/id-recovery/store', [AssetMatchingController::class, 'storeId'])->name('assets.store-id');
    // Resource handles: index, create, store, show, edit, update, destroy
    Route::resource('assets', AssetMatchingController::class);

    // --- STUDENT PROFILES & SEARCH ---
    Route::get('/students', [StudentProfileController::class, 'index'])->name('students.index');
    Route::post('/students/import', [StudentProfileController::class, 'import'])->name('students.import'); // NEW IMPORT ROUTE
    Route::get('/students/{student_id}', [StudentProfileController::class, 'show'])->name('students.show');

    // --- DISCIPLINARY HUB (Violations) ---
    Route::get('/violations/report', [ViolationReportController::class, 'index'])->name('violations.report');
    Route::get('/violations/create', [ViolationController::class, 'create'])->name('violations.create');
    Route::post('/violations', [ViolationController::class, 'store'])->name('violations.store');

    // VIOLATION CRUD ROUTES
    Route::get('/violations/{id}', [ViolationController::class, 'show'])->name('violations.show');
    Route::get('/violations/{id}/edit', [ViolationController::class, 'edit'])->name('violations.edit');
    Route::put('/violations/{id}', [ViolationController::class, 'update'])->name('violations.update');
    Route::delete('/violations/{id}', [ViolationController::class, 'destroy'])->name('violations.destroy');

    // --- GATE ENTRY TERMINAL (CRUD) ---
    // Added index and store routes to fix the "Route not found" error
    Route::get('/gate-entry', [GateEntryController::class, 'index'])->name('gate.index');
    Route::post('/gate-entry', [GateEntryController::class, 'store'])->name('gate.store');

    // Additional Log Management
    Route::get('/gate-entry/{id}/edit', [GateEntryController::class, 'edit'])->name('gate.edit');
    Route::put('/gate-entry/{id}', [GateEntryController::class, 'update'])->name('gate.update');
    Route::delete('/gate-entry/{id}', [GateEntryController::class, 'destroy'])->name('gate.destroy');

    // --- USER ACCOUNT MANAGEMENT ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('incidents', App\Http\Controllers\IncidentReportController::class);
});

require __DIR__ . '/auth.php';
