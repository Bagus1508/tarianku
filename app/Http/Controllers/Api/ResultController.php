<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizQuestionResource;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $quizResult = QuizResult::where('name', $request->name)->first();

        if (is_null($quizResult)) {
            return new QuizQuestionResource(false, 'Hasil Quiz Tidak Ditemukan', $quizResult);
        }

        return new QuizQuestionResource(true, 'Hasil Quiz Berhasil Ditemukan', $quizResult);
    }
}
