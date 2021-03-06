<?php

namespace Quizviran\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Room extends Model
{
    protected $guarded = ['id'];

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getUrlAttribute()
    {
        return route('quizviran.room.show', ['room' => $this->link]);
    }

    public function getJalalyCreatedAtAttribute()
    {
        return jalalyYMD($this->created_at);
    }

    public function toArray()
    {
        $array = parent::toArray();

        return array_merge($array, [
            'url' => $this->url,
            'jalalyCreatedAt' => $this->jalalyCreatedAt,
        ]);
    }
}
