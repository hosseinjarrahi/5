<?php

namespace App\Models\Main;

use App\Models\Quiz\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
