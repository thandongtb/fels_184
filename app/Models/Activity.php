<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'activities';
    protected $fillable = [
        'user_id',
        'target_id',
        'object_id',
        'content',
    ];

    public function object()
    {
        $targetClass = config('activity.target.' . $this->target_id . '.target_model');

        return $this->belongsTo($targetClass, 'object_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function linkToObject()
    {
         $targetController = config('activity.target.' . $this->target_id . '.target_controller');

         return action($targetController . '@show', ['id' => $this->target_id]);
    }
}
