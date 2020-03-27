<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
