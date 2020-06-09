<?php

namespace Quizviran\Models;

use Carbon\Carbon;
use App\Models\File;
use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Exam extends Model
{
    protected $guarded = ['id'];

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
        return $this->belongsToMany(User::class, 'exam_user', 'exam_id', 'user_id')->withPivot('norm', 'answers');
    }

    public function isInTime()
    {
        return $this->start->subMinutes(1)->lte(Carbon::now()) && $this->start->addMinutes($this->duration + 1)->gte(Carbon::now());
    }

    public function showable()
    {
        return $this->show && $this->isInTime();
    }

    public function isPublic()
    {
        return $this->type == 'public';
    }

    public function showableForMembers()
    {
        return $this->showable() || auth()->user()->isTeacher();
    }

    public function getExamUsersWithNorms()
    {
        return $this->users()->withPivot('norm')->get()->sortByDesc('pivot.norm');
    }

    public function getExamUsersWithPivot()
    {
        return $this->users()->withPivot([
            'norm',
            'answers',
        ])->get()->sortByDesc('pivot.norm');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function scopePublic($query)
    {
        return $query->where('type', 'public');
    }

    public function scopeShow($query)
    {
        return $query->where('show', 1);
    }

    public function getJalalyAttribute()
    {
        return jalaly($this->getAttribute('start'))->format('H:i m/d');
    }

    public function getLinkAttribute()
    {
        return route('quizviran.exam.show',['exam' => $this->id]);
    }

    public function getResultLinkAttribute()
    {
        return route('quizviran.exam.result.student',['exam' => $this->id]);
    }

    public function getStartForHumansAttribute()
    {
        return $this->start->diffForHumans();
    }

    public function getRemainedTimeAttribute()
    {
        return $this->duration - Carbon::now()->diffInMinutes($this->start);
    }

    public function toArray()
    {
        $array = parent::toArray();

        return array_merge($array,[
            'resultLink' => $this->resultLink,
            'startForHumans' => $this->startForHumans,
            'startJalaly' => $this->jalaly,
            'isInTime' => $this->isInTime(),
            'duration' => $this->duration,
            'remainedTime' => $this->remainedTime,
            'link' => $this->link,
        ]);
    }
}
