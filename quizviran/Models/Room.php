<?php

namespace Quizviran\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Room extends Model
{
    protected $with = ['user'];
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
}
