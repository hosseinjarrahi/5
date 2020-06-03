<?php

namespace Quizviran\Models;

use App\Models\User;
use App\Models\Category;
use Conner\Tagging\Model\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    public $with = [
        'categories'
    ];

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

    public function categories()
    {
        return $this->morphToMany(Category::class, 'model','categories_models');
    }

}
