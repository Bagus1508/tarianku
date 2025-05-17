<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'quiz_questions';

    protected $fillable = [
        'dance_id',
        'question_text',
        'correct_answer',
        'points',
        'difficulty',
        'type',
        'attachment1'
    ];

    /**
     * Relasi ke model Dance (jika ada).
     */
    public function dance()
    {
        return $this->belongsTo(Dance::class);
    }

    public function options()
    {
        return $this->hasMany(QuizQuestionOption::class);
    }

    public function getAttachmentUrlAttribute()
    {
        return transformedUrlAttachment($this->attachment1);
    }

    protected $appends = [
        'attachment_url',
    ];
}
