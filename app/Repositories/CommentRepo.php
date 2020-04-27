<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepo
{
    public static function create($request)
    {
        return Comment::create([
            'comment' => $request->comment,
            'commentable_type' => $request->type,
            'commentable_id' => $request->id,
            'show' => true,
            'user_id' => auth()->id(),
        ]);
    }

}