<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    protected $with = ['user','files'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphMany(File::class,'fileable');
    }

    public function isOwn()
    {
        return $this->user_id == auth()->id();
    }

    public function isOwnMember()
    {
        if(!cache('user')->isTeacher())
            return false;
        return true;
    }
}
