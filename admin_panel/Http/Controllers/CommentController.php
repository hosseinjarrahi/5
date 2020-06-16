<?php

namespace Admin\Http\Controllers;

use App\Models\Comment;
use Illuminate\Routing\Controller;
use Admin\repositories\CommentRepo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        /**
         * @get('/manager/comment')
         * @name('admin.comment.index')
         * @middlewares(web, auth, admin)
         */
        $comments = CommentRepo::withUser(9);

        return view('Admin::comments', compact('comments'));
    }

    public function update(Comment $comment,Request $request)
    {
        /**
         * @methods(PUT, PATCH)
         * @uri('/manager/comment/{comment}')
         * @name('admin.comment.update')
         * @middlewares(web, auth, admin)
         */
        if (! $comment->isOwn() && !auth()->user()->isAdmin()) {
            return response(['message' => 'امکان ویرایش این نظر برای شما فراهم نیست.']);
        }

        CommentRepo::update($comment,$request->only(['comment']));

        return back();
    }

    public function destroy(Comment $comment)
    {
        /**
         * @delete('/manager/comment/{comment}')
         * @name('admin.comment.destroy')
         * @middlewares(web, auth, admin)
         */
        $comment->delete();

        return back();
    }
}
