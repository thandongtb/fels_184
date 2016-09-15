<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'description',
        'photo'
    ];

    public function getPhotoUrl()
    {
        return asset(config('common.category.path.photo_url') . $this->photo);
    }
}
