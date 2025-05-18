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

    public array $typeEnums = [
        1 => 'Tanpa Gambar',
        2 => 'Dengan Gambar',
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
        if(($this->type === 2) && is_null($this->attachment1)) {
            return asset('image/no_image.jpg');
        }

        return transformedUrlAttachment($this->attachment1);
    }

    public function getTypeDescriptionAttribute()
    {
        return $this->typeEnums[$this->type] ?? null;
    }

    protected $appends = [
        'type_description',
        'attachment_url',
    ];
}
