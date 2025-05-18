<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizQuestionResource;
use Illuminate\Http\Request;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnswerQuizController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'quiz_result_id' => 'required|exists:quiz_results,id',
            'quiz_question_id' => 'required|exists:quiz_questions,id',
            'quiz_option_id' => 'required|exists:quiz_question_options,id',
            // 'is_correct' => 'required|boolean',
            'time_taken' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ambil pertanyaan dan opsi yang dipilih
        $question = QuizQuestion::with('options')->findOrFail($request->quiz_question_id);
        $selectedOption = $question->options->firstWhere('id', $request->quiz_option_id);

        if (!$selectedOption) {
            return response()->json(['error' => 'Opsi tidak valid untuk pertanyaan ini'], 422);
        }

        // Tentukan kebenaran jawaban
        $isCorrect = $selectedOption->is_correct;
        $point = $isCorrect ? ($question->points ?? 0) : 0;

        $answer = QuizAnswer::create([
            'quiz_result_id' => $request->quiz_result_id,
            'quiz_question_id' => $request->quiz_question_id,
            'quiz_option_id' => $request->quiz_option_id,
            'is_correct' => $isCorrect,
            'time_taken' => $request->time_taken,
            'point_earned' => $point,
        ]);
        DB::commit();

        return new QuizQuestionResource(true, 'Jawaban Berhasil Dikirim', $answer);
    }
}
