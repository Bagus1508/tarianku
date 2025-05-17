<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizQuestionResource;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    public function index()
    {
        $quizQuestions = QuizQuestion::with('options')->get();

        return new QuizQuestionResource(true, 'List Data Soal', $quizQuestions);
    }
}
