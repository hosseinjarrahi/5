<?php

namespace Quizviran\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['has.room'])->except(['store']);
    }

    public function paginate(Request $request)
    {
        $room = session('room');
        $comments = $room->comments()->orderByDesc('id')->paginate(10);

        return response(['comments' => $comments]);
    }

    public function ok(Comment $comment)
    {
        $comment->update(['show' => true]);

        return back();
    }
}
