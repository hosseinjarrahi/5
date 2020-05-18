<?php

namespace Quizviran\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Room extends Model
{
    protected $with = ['user','members'];
    protected $guarded = ['id'];

    public function quizzes(){
        return $this->belongsToMany(Quiz::class);
    }

    public function members(){
        return $this->belongsToMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
