<?php

namespace App\Models\Quiz;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sends(){
        return $this->hasMany(Send::class);
    }

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

}
