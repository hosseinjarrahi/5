<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [
        'id'
    ];

    public $casts = [
        'payload' => 'array'
    ];

    public function paymantable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
