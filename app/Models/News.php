<?php

namespace App\Models;

use AliBayat\LaravelCategorizable\Categorizable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Categorizable;

    public function tags()
    {
        return $this->morphToMany(Tag::class,'tagable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
