<?php

namespace App\Models\Quiz;

use App\Models\Main\Tag;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'app_questions';

    public function quizzes()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class,'tagable');
    }
}
