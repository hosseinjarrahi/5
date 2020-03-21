<?php

namespace App\Models\Main;

use App\Models\Quiz\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
