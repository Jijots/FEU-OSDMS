<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssetController;

// Default User Route (Sanctum Auth)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
// YOUR INTELLITHINGS ROUTE
Route::post('/assets/match-visual', [AssetController::class, 'checkVisualMatch']);
