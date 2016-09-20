<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Social;
use Auth;
use Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role == config('user.role.admin');
    }

    public function isCurrent()
    {
        if (Auth::check()) {
            return Auth::user()->id == $this->id;
        }

        return false;
    }

    public function typeRegister()
    {
        $social =  Social::where('user_id', $this->id)->first();

        if (count($social)) {
            return $social->provider;
        }

        return trans('homepage.type_register_normal');
    }

    public function isNullPassword()
    {
        return $this->password == null;
    }


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function isFollowedByAnother(User $anotherUser)
    {
        return $anotherUser->followings()->where('followed_id', $this->id)->first();
    }

    public function isFollowingAnother(User $anotherUser)
    {
        return $anotherUser->followers()->where('follower_id', $this->id)->first();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'relationships', 'followed_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'relationships', 'follower_id', 'followed_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
