<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $casts = [
        'start' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'quiz_user', 'user_id', 'quiz_id')
            ->withPivot('norm','answers');
    }

    public function isInTime()
    {
        return $this->start->subMinutes(1)->lte(Carbon::now()) && $this->start->addMinutes($this->duration + 1)->gte(Carbon::now());
    }
}
