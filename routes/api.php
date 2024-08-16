<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportImageController;
use App\Http\Controllers\SportVideoController;
use App\Http\Controllers\SportController;

// Routes for sport images
Route::apiResource('sport-images', SportImageController::class);

// Routes for sport videos
Route::apiResource('sport-videos', SportVideoController::class);
Route::apiResource('sports', SportController::class);
// Route::get('sport/{sport}', [SportController::class, 'show'])->name('sports.show');


