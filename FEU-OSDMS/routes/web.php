<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssetMatchingController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\ViolationReportController;
use App\Http\Controllers\GateEntryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // If the user is logged in, go to dashboard. If not, go to login.
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // IntelliThings
    Route::get('/assets', [AssetMatchingController::class, 'index'])->name('assets.index');
    Route::get('/assets/{asset_id}/compare', [AssetMatchingController::class, 'compare'])->name('assets.compare');

    // Students
    Route::get('/students', [StudentProfileController::class, 'index'])->name('students.index');
    Route::get('/students/{student_id}', [StudentProfileController::class, 'show'])->name('students.show');

    // Violations
    Route::get('/violations', [ViolationController::class, 'index'])->name('violations.index');
    Route::get('/violations/create', [ViolationController::class, 'create'])->name('violations.create');
    Route::post('/violations', [ViolationController::class, 'store'])->name('violations.store');

    // Reports
    Route::get('/reports/violations', [ViolationReportController::class, 'index'])->name('violations.report');

    // Gate Entry
    Route::get('/gate-entry', [GateEntryController::class, 'index'])->name('gate.index');
    Route::post('/gate-entry', [GateEntryController::class, 'store'])->name('gate.store');
});

require __DIR__.'/auth.php';
