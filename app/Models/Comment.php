<?php

namespace App\Models;

use Quizviran\Models\Room;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    protected $with = ['user'];

    protected $perPage = 20;

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
        if(auth()->user()->type != 'teacher')
            return false;
        return true;
    }
}
