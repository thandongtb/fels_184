<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'answer_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Models\Lesson');
    }

    public function answer()
    {
        return $this->belongsTo('App\Models\Answer');
    }
}
