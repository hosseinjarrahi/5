<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepo
{
    public static function create($request)
    {
        return Comment::create([
            'comment' => $request['comment'],
            'commentable_type' => $request['type'],
            'commentable_id' => $request['id'],
            'show' => true,
            'user_id' => auth()->id(),
        ]);
    }

    public static function hiddenCreate($request)
    {
        return Comment::create([
            'comment' => $request['comment'],
            'commentable_id' => $request['id'],
            'commentable_type' => $request['type'],
            'user_id' => auth()->id()
        ]);
    }

    public static function findOrFail($id)
    {
        return Comment::findOrFail($id);
    }

    public static function update($comment,$request)
    {
        $comment->comment = $request->comment;
        $comment->save();
    }

    public static function hiddenUpdate($comment,$request)
    {
        $comment->comment = $request['comment'];
        $comment->show = false;
        return $comment->save();
    }

    public static function delete($comment)
    {
        return $comment->delete();;
    }
}
