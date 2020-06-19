<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    protected $with = [
        'user',
        'files',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function isOwn()
    {
        return $this->user_id == auth()->id();
    }

    public function isOwnMember()
    {
        if (! auth()->user()->isTeacher()) {
            return false;
        }

        return true;
    }

    public function toArray()
    {
        // todo : change to module quizviran comment
        $array = parent::toArray();

        return array_merge($array, [
            'updateLink' => route('comment.update',['comment' => $this->id]),
            'deleteLink' => route('comment.destroy',['comment' => $this->id]),
        ]);
    }
}
