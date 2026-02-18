<?php
use App\Http\Controllers\{ProfileController, AssetMatchingController, StudentProfileController, ViolationController, ViolationReportController, GateEntryController, DashboardController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // IntelliThings (Innovation)
    Route::get('/assets', [AssetMatchingController::class, 'index'])->name('assets.index');
    Route::get('/assets/{asset_id}/compare', [AssetMatchingController::class, 'compare'])->name('assets.compare');

    // Student Profiles (Efficiency)
    Route::get('/students', [StudentProfileController::class, 'index'])->name('students.index');
    Route::get('/students/{student_id}', [StudentProfileController::class, 'show'])->name('students.show');

    // Violations (Action vs Intelligence)
    Route::resource('violations', ViolationController::class);
    Route::get('/reports/violations', [ViolationReportController::class, 'index'])->name('violations.report');

    // Gate Entry (Security)
    Route::get('/gate-entry', [GateEntryController::class, 'index'])->name('gate.index');
    Route::post('/gate-entry', [GateEntryController::class, 'store'])->name('gate.store');
});

require __DIR__.'/auth.php';