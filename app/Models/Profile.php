<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ? $this->attributes['avatar'] :'/img/avatar.svg';
    }

    public function toArray()
    {
        $array = parent::toArray();

        return array_merge($array,[

        ]);
    }
}
