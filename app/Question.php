<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'app_questions';

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
