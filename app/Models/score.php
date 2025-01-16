<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class score extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'score',
    ];

    public function question()
    {
        return $this->belongsTo(question::class, 'question_id', 'id');
    }
}
