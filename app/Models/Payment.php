<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
