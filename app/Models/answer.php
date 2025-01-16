<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'answer_txt',
        'category_id',
        'answer_score',
        'multiple_choice',
        'question_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(question::class, 'question_id', 'id');
    }
}
