<?php

namespace Quizviran\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Room extends Model
{
    protected $guarded = ['id'];

    public function quizzes(){
        return $this->belongsToMany(Quiz::class);
    }

    public function members(){
        return $this->hasMany(User::class);
    }

    public function admin(){
        return $this->hasOne(User::class);
    }
}
