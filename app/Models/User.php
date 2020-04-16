<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Quizviran\Models\Quiz;
use Quizviran\Models\Room;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    public $with = [
        'profile'
    ];

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function quizzes()
    {
        return $this
            ->belongsToMany(Quiz::class,
                'quiz_user',
                'user_id',
                'quiz_id'
            )->withPivot('norm','answers');
    }

    public function checkForQuiz($id){
        return !$this->query()->quizzes()->has();
    }

    public function canComplete($quizId)
    {
        return $this->quizzes()->where('id',$quizId)->get()->isEmpty();
    }

    public function isAdmin()
    {
        if($this->userid == 1) return true;
        return false;
    }

    public function fileInQuiz($quiz_id)
    {
        return $this->files()->where([
            'fileable_id' => $quiz_id,
            'fileable_type' => 'quiz',
        ]);
    }

    public function products()
    {
        return $this->hasMany(Product::class);    
    }

    public function rooms()
    {
        if($this->type == 'teacher')
            return $this->hasMany(Room::class); 
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
        return $this->hasOneThrough(Quiz::class,Room::class);
    }

    public function scopeStudents($query)
    {
        return $query->where('type','student');
    }

    public function scopeTeachers($query)
    {
        return $query->where('type','teacher');
    }

    public function scopeBestStudents($query)
    {
        return $query->students()->whereHas('profile',function(Builder $query){
            $query->where('point','>',0)->orderByDesc('point');
        });
    }

    public function hasRoom($room)
    {
        if($this->type == 'teacher')
            return $this->id == $room->user->id;
        return !$room->members()->where('id',$this->id)->first()->isEmpty();
    }

}
