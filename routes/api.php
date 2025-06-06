<?php

use App\Http\Controllers\Api\AnswerQuizController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DanceController;
use App\Http\Controllers\Api\QuizQuestionController;
use App\Http\Controllers\Api\ResultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* Dance API */
Route::get('/dances', [DanceController::class, 'index']);
Route::get('/dance/{id}', [DanceController::class, 'show']);

/* Categories API */
Route::get('/categories', [CategoryController::class, 'index']);

/* Quiz Question API */
Route::get('/quiz-questions', [QuizQuestionController::class, 'index']);

/* Quiz Answer API */
Route::post('/answer-quiz', [AnswerQuizController::class, 'store']);

/* Quiz Result */
Route::get('/quiz-result', [ResultController::class, 'index']);