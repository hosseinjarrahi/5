<?php

namespace App\Models\Main;

use App\Models\Quiz\User;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function tags()
    {
        return $this->morphToMany(Tag::class,'tagable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
