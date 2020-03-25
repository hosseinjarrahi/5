<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function questions()
    {
        return $this->morphedByMany(Question::class,'tagable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class,'tagable');
    }
}
