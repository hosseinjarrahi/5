<?php

namespace App\Models;

use Quizviran\Models\Question;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Quizviran\Models\Exam;
use Quizviran\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = true;

    public $with = [
        'profile',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_user', 'user_id', 'exam_id')->withPivot('norm', 'answers');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function checkForQuiz($id)
    {
        return ! $this->query()->exams()->has();
    }

    public function canComplete($examId)
    {
        return $this->exams()->where('id', $examId)->get()->isEmpty();
    }

    public function isAdmin()
    {
        if ($this->email == 'hj021hj@gmail.com') {
            return true;
        }

        return false;
    }

    public function fileInExam($examId)
    {
        return $this->files()->where([
            'fileable_id' => $examId,
            'fileable_type' => 'quiz',
        ]);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function rooms()
    {
        if ($this->isTeacher()) {
            return $this->hasMany(Room::class);
        }

        return $this->belongsToMany(Room::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function hasQuiz()
    {
        // todo
        return $this->hasOneThrough(Exam::class, Room::class);
    }

    public function scopeStudents($query)
    {
        return $query->where('type', 'student');
    }

    public function scopeTeachers($query)
    {
        return $query->where('type', 'teacher');
    }

    public function scopeBestStudents($query)
    {
        return $query->students()->whereHas('profile', function (Builder $query) {
            $query->where('point', '>', 0)->orderByDesc('point');
        });
    }

    public function hasRoom($room)
    {
        if ($this->isTeacher()) {
            return $this->id == $room->user_id;
        }

        return $room->members()->where('id', $this->id)->first();
    }

    public function isTeacher()
    {
        return $this->type == 'teacher';
    }

    public function hasExam($exam)
    {
        if ($this->isTeacher()) {
            return $exam->user_id == $this->id;
        }

        $room = $exam->rooms()->whereHas('members', function ($query) {
            $query->where('user_id', $this->id);
        })->first();

        return $room;
    }

    public function hasQuestion($questionUserId)
    {
        if ($this->isTeacher() && $questionUserId == $this->id) {
            return true;
        }

        return false;
    }

    public function teacherHasRoom($room)
    {
        return $this->hasRoom($room) && $this->isTeacher();
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
