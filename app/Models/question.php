<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'question_txt',
        'question_type',
        'score_value',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function score()
    {
        return $this->hasMany(score::class, 'question_id', 'id');
    }
}
