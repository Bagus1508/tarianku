<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'total_correct',
        'total_questions',
        'total_time',
        'total_point',
    ];

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
