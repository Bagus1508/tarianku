<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dance extends Model
{
    use SoftDeletes;

    protected $table = 'dances';

    protected $fillable = [
        'categories_id',
        'title',
        'description',
        'origin_region',
        'attachment1',
        'attachment2',
        'is_archived',
        'difficulty_level',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'difficulty_level' => 'integer',
    ];

    /**
     * Relasi ke model Category.
     * Diasumsikan model kategori bernama "Category" dan memiliki relasi one-to-many.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }
}
