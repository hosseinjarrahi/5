<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'qa_users';

    protected $primaryKey = 'userid';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
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
}
