<?php

namespace Quizviran\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\Paginator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['has.room'])->except(['store']);
    }

    public function paginate(Request $request)
    {
        $room = cache('room');
        $comments = $room->comments()->orderByDesc('id')->paginate(10);

        return response(['comments' => $comments]);
    }
}
