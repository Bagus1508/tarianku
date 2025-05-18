<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $fillable = [
        'quiz_result_id',
        'quiz_question_id',
        'quiz_option_id',
        'is_correct',
        'time_taken',
        'point_earned'
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function option()
    {
        return $this->belongsTo(QuizQuestionOption::class, 'quiz_option_id');
    }
}
