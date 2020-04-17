<?php

namespace Quizviran\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Quiz extends Model
{
    protected $guarded = ['id'];
    protected $perPage = 20;
    protected $casts = [
        'start' => 'datetime',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'quiz_user', 'quiz_id', 'user_id')->withPivot('norm', 'answers');
    }

    public function isInTime()
    {
        return $this->start->subMinutes(1)->lte(Carbon::now()) && $this->start->addMinutes($this->duration + 1)->gte(Carbon::now());
    }

    public function getQuizUsersWithNorms()
    {
        return $this->users()->withPivot('norm')->get()->sortByDesc('pivot.norm');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function scopePublic($query)
    {
        return $query->where('type','public');
    }

    public function scopeShow($query)
    {
        return $query->where('show',1);
    }
//
//    public function toArray()
//    {
//        return [
//            'id' => $this->id,
//            'name' => $this->name,
//            'link' => url("/quiz/exam/{$this->id}"),
//            'desc' => $this->desc,
//            'start' => $this->start->diffForHumans(),
//            'duration' => $this->duration - Carbon::now()->diffInMinutes($this->start),
//            'time' => $this->duration
//        ];
//    }
}
