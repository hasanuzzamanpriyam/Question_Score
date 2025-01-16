<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'panel_type',
        'created_by',
    ];

    public function question()
    {
        return $this->hasMany(question::class, 'category_id', 'id');
    }

    public function answer()
    {
        return $this->hasMany(answer::class, 'category_id', 'id');
    }
}
