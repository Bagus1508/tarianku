<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizQuestionResource;
use Illuminate\Http\Request;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use App\Models\QuizResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnswerQuizController extends Controller
{
    public function store(Request $request)
    {
        //Model
        $answerData = QuizAnswer::where('user_name', $request->user_name)->first();

        //Create New ID
        $oldId = QuizAnswer::latest()->pluck('id')->first();
        $newId = $oldId + 1;

        //user name dynamic
        if ($answerData) {
            $request['user_name'] = $answerData->user_name;

            $isQuestionAnswered = intval($answerData->quiz_question_id) === intval($request->quiz_question_id ?? 0);
        } else {
            $request['user_name'] = $request->user_name . strval($newId);
            $isQuestionAnswered = false;
        }

        //Return if queztion has answered
        if ($isQuestionAnswered) {
            return response()->json(['error' => 'Pertanyaan Sudah Terjawab!'], 400);
        }

        //Validation Start
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'quiz_question_id' => 'required|exists:quiz_questions,id',
            'quiz_option_id' => 'required|exists:quiz_question_options,id',
            // 'is_correct' => 'required|boolean',
            'time_taken' => 'required|integer',
            'user_name' => 'required|string',
        ]);
        //Validation End

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
            'user_name' => $request->user_name,
            'quiz_result_id' => $request->quiz_result_id,
            'quiz_question_id' => $request->quiz_question_id,
            'quiz_option_id' => $request->quiz_option_id,
            'is_correct' => $isCorrect,
            'time_taken' => $request->time_taken,
            'point_earned' => $point,
        ]);

        //Update Result
        $quizResult = QuizResult::where('name', $answer->user_name)->first();

        if ($quizResult) {
            $updateResult = $quizResult->update([
                'total_correct' => intval($quizResult->total_correct) + ($isCorrect ? 1 : 0),
                'total_questions' => intval($quizResult->total_questions) + 1,
                'total_time' => intval($quizResult->total_time) + intval($answer->time_taken),
                'total_point' => intval($quizResult->total_point) + intval($point),
            ]);

            DB::commit();

            return new QuizQuestionResource(true, 'Hasil Berhasil Diupdate', $quizResult);
        } else {
            $createResult = QuizResult::create([
                'name' => $answer->user_name,
                'total_correct' => $isCorrect ? 1 : 0,
                'total_questions' => 1,
                'total_time' => $answer->time_taken,
                'total_point' => $point,
            ]);

            DB::commit();

            return new QuizQuestionResource(true, 'Hasil Berhasil Ditambahkan', $createResult);
        }

        DB::commit();

        return new QuizQuestionResource(true, 'Jawaban Berhasil Dikirim', $answer);
    }
}
