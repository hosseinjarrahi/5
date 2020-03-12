<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    public function sends()
    {
        return $this->hasMany(Send::class);
    }
}
