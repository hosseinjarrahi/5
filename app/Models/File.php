<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function isOwn()
    {
        return auth()->id() == $this->user_id;
    }

}
