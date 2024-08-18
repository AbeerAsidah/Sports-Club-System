<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportImageController;
use App\Http\Controllers\SportVideoController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FacilityController;


// Routes for sport images
// Route::apiResource('sport-images', SportImageController::class);

// // Routes for sport videos
// Route::apiResource('sport-videos', SportVideoController::class);
// Route::apiResource('sports', SportController::class);


Route::prefix('sport-images')->group(function () {
    Route::get('/', [SportImageController::class, 'index']);
    Route::get('sports/{id}', [SportImageController::class, 'imagesBySport']);
    Route::post('sports/{id}', [SportImageController::class, 'store']);
    Route::get('{sportImage}', [SportImageController::class, 'show']);
    Route::post('{sportImage}', [SportImageController::class, 'update']);
    Route::post('delete/{sportImage}', [SportImageController::class, 'destroy']);
});

Route::prefix('sport-videos')->group(function () {
    Route::get('/', [SportVideoController::class, 'index']);
    Route::post('/', [SportVideoController::class, 'store']);
    Route::get('{sportVideo}', [SportVideoController::class, 'show']);
    Route::post('{sportVideo}', [SportVideoController::class, 'update']);
    Route::post('delete/{sportVideo}', [SportVideoController::class, 'destroy']);
});


Route::prefix('sports')->group(function () {
    Route::get('/', [SportController::class, 'index']);
    Route::post('/', [SportController::class, 'store']);
    Route::get('{sport}', [SportController::class, 'show']);
    Route::post('{sport}', [SportController::class, 'update']);
    Route::post('delete/{sport}', [SportController::class, 'destroy']);
});

Route::prefix('facilities')->group(function () {
    Route::get('/', [FacilityController::class, 'index']);
    Route::post('/', [FacilityController::class, 'store']);
    Route::get('{facility}', [FacilityController::class, 'show']);
    Route::post('{facility}', [FacilityController::class, 'update']);
    Route::post('delete/{facility}', [FacilityController::class, 'destroy']);
});

Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('sport/{id}', [RoomController::class, 'roomsBySport']);
    Route::post('/', [RoomController::class, 'store']);
    Route::get('{room}', [RoomController::class, 'show']);
    Route::post('{room}', [RoomController::class, 'update']);
    Route::post('delete/{room}', [RoomController::class, 'destroy']);
});


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('{category}', [CategoryController::class, 'show']);
    Route::post('{category}', [CategoryController::class, 'update']);
    Route::post('delete/{category}', [CategoryController::class, 'destroy']);
});

Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('category/{id}', [ArticleController::class, 'articlesByCategory']);
    Route::post('/', [ArticleController::class, 'store']);
    Route::get('{article}', [ArticleController::class, 'show']);
    Route::post('{article}', [ArticleController::class, 'update']);
    Route::post('delete/{article}', [ArticleController::class, 'destroy']);
});