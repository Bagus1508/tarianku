<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* Dance API */
Route::get('/dances', [DanceController::class, 'index']);

/* Categories API */
Route::get('/categories', [CategoryController::class, 'index']);
