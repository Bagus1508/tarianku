<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'quiz_question_id',
        'selected_option',
        'is_correct',
        'time_taken',
    ];

    public function quiz_question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function selectedOption()
    {
        return $this->belongsTo(QuizQuestionOption::class, 'selected_option');
    }
}
