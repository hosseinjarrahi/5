<?php

namespace Admin\repositories;

use App\Models\Comment;
use Illuminate\Support\Facades\File;

class CommentRepo
{
    public static function withUser($paginate = 10)
    {
        return Comment::orderByDesc('id')->with('user')->paginate($paginate);
    }

    public static function update($comment,$request)
    {
        $comment->comment = $request['comment'] ?? $comment->comment;
        $comment->show = cache('user')->isAdmin() ? $comment->show : !$comment->show;
        return $comment->save();
    }

    public static function delete($comment)
    {
        foreach ($comment->files ?? [] as $file) {
                File::delete(storage_path('app/'.$file->path));
                $file->delete();
        }

        return $comment->delete();
    }
}
