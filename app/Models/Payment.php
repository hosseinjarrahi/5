<?php

namespace App\Models\Main;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
