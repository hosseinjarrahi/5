<?php

namespace Quizviran\Models;

use App\Models\User;
use AliBayat\LaravelCategorizable\Categorizable;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Categorizable;

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function tags()
    // {
    //     return $this->morphToMany(Tag::class,'tagable');
    // }


}
