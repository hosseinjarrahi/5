<?php

namespace Admin\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::orderByDesc('id')->with('user')->paginate(9);
        return view('Admin::comments',compact('comments'));
    }

    public function update(Comment $comment)
    {
        $comment->show = !$comment->show;
        $comment->save();
        return back();
    }

    public function destroy(User $user)
    {
        if($user->profile) {
            File::delete(public_path($user->profile->avatar));
            $user->profile()->delete();
        }
        $user->delete();
        return back();
    }
}