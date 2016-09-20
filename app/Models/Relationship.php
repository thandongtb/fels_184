<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'relationships';
    protected $fillable = [
        'follower_id',
        'followed_id'
    ];

    public function follower()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function followed()
    {
        return $this->belongsTo('App\Models\User');
    }
}
