<?php

namespace App\Models;

use Quizviran\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['user_id'];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'model','categories_models');
    }

    public function questions()
    {
        return $this->morphedByMany(Question::class, 'model','categories_models');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
