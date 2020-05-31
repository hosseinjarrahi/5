<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Repositories\CommentRepo;
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
        CommentRepo::hiddenCreate($request->only([
            'comment',
            'id',
            'type',
        ]));

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
        if ($comment->isOwn()) {
            CommentRepo::hiddenUpdate($comment, $request->only(['comment']));

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
            CommentRepo::delete($comment);

            return response(['message' => 'با موفقیت حذف شد.']);
        }

        return response(['message' => 'متاسفانه مشکلی رخ داده است.'], 400);
    }
}
