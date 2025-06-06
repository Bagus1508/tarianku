<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $fillable = [
        'quiz_question_id',
        'quiz_option_id',
        'is_correct',
        'time_taken',
        'point_earned',
        'user_name'
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
