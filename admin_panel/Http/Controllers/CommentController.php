<?php

namespace Admin\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    public function index()
    {
        /** 
         * @get('/manager/comment')
         * @name('admin.comment.index')
         * @middlewares(web, auth, admin)
         */
        $comments = Comment::orderByDesc('id')->with('user')->paginate(9);
        return view('Admin::comments',compact('comments'));
    }

    public function update(Comment $comment)
    {
        /** 
         * @methods(PUT, PATCH)
         * @uri('/manager/comment/{comment}')
         * @name('admin.comment.update')
         * @middlewares(web, auth, admin)
         */
        if(!$comment->isOwn)
            return response(['message' => 'امکان ویرایش این نظر برای شما فراهم نیست.']);
        $comment->show = !$comment->show;
        $comment->save();
        return back(['message' => 'با موفقیت انجام شد']);
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