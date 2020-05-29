<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(CommentRequest $request)
    {
        /** 
         * @post('/comment')
         * @name('comment.store')
         * @middlewares(web, auth)
         */
        Comment::create([
            'comment' => $request->comment,
            'commentable_id' => $request->id,
            'commentable_type' => $request->type,
            'user_id' => auth()->id()
        ]);
    
        return response(['message' => 'پس از تایید ، نظر شما نمایش داده خواهد شد.']);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        /** 
         * @methods(PUT, PATCH)
         * @uri('/comment/{comment}')
         * @name('comment.update')
         * @middlewares(web, auth)
         */
        if($comment->isOwn())
        {
            $comment->comment = $request->comment;
            $comment->show = false;
            $comment->save();
            return response(['message' => 'با موفقیت ویرایش شد.پس از تایید قرار خواهد گرفت.']);
        }

        return response(['message' => 'مشکلی رخ داده است.']);
    }

    public function destroy(Comment $comment)
    {
        /** 
         * @delete('/comment/{comment}')
         * @name('comment.destroy')
         * @middlewares(web, auth)
         */
        if ($comment->isOwn()) {
            $comment->delete();
            return response(['message' => 'با موفقیت حذف شد.']);
        }
        return response(['message' => 'متاسفانه مشکلی رخ داده است.'],400);
    }
}
