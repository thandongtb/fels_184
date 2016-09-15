<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonWord extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'lesson_words';
    protected $fillable = [
        'lesson_id',
        'word_id'
    ];

    public function lesson()
    {
        return $this->belongsTo('App\Models\Lesson');
    }

    public function word()
    {
        return $this->belongsTo('App\Models\Word');
    }
}
