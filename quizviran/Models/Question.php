<?php

namespace Quizviran\Models;

use App\Models\User;
use Conner\Tagging\Model\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }


}
