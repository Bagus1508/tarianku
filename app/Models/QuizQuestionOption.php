<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestionOption extends Model
{
    protected $fillable = ['quiz_question_id', 'option_text', 'is_correct', 'attachment1'];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function getAttachmentUrlAttribute()
    {
        return transformedUrlAttachment($this->attachment1);
    }

    protected $appends = [
        'attachment_url',
    ];
}
