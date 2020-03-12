<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Send extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
