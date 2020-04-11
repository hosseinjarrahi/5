<?php

namespace App\Models;

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

    public function tags()
    {
        return $this->morphToMany(Tag::class,'tagable');
    }
}
