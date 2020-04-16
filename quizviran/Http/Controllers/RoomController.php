<?php

namespace Quizviran\Http\Controllers;

use App\Models\File;
use App\Models\Comment;
use Quizviran\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Http\Resources\QuizResourse;
use Morilog\Jalali\Jalalian;

class RoomController extends Controller
{
    public function __construct()
    {
        if (!auth()->check())
            return abort(404);
    }

    public function create()
    {
        return view('Quizviran::panel.teacher.roomCreate');
    }

    public function show($room)
    {
        $room = Room::where('link', $room)->with([
            'comments',
            'comments.files'
        ])->withCount('members')->firstOrFail();

        if(!auth()->user()->hasRoom($room))
            return abort(404);

        $room->created_at = Jalalian::forge($room->created_at);
        $quizzes = QuizResourse::collection($room->quizzes);
        return view('Quizviran::panel.teacher.room', compact('room', 'quizzes'));
    }

    public function store()
    {
        if(auth()->user()->type != 'teacher')
            return abort(404);

        $request = request();

        $room1 = true;
        while ($room1 || $room2) {
            $link = \Str::random(10);
            $code = random_int(100000, 999999);
            $room1 = Room::where('link', $link)->first();
            $room2 = Room::where('code', $code)->first();
        }

        $room = Room::create([
            'name' => $request->name,
            'link' => $link,
            'user_id' => auth()->id(),
            'code' => $code,
        ]);

        return view('Quizviran::panel.teacher.roomCreated', compact('room'));
    }
    public function addComment(Request $request)
    {
        $files = collect($request->post('files'));
        $files = File::find($files->pluck('id'));
        $comment = Comment::create([
            'comment' => $request->comment,
            'commentable_type' => $request->type,
            'commentable_id' => $request->id,
            'show' => true,
            'user_id' => auth()->id(),
        ]);
        $comment->files()->saveMany($files);
        return response(['message' => 'با موفقیت اضافه شد']);
    }

    public function updateComment(Comment $comment,Request $request)
    {
        if(!$comment->isOwn())
            return response(['message' => 'این نظر قابل ویرایش نیست.'],400);
        $comment->comment = $request->comment;
        $comment->save();
        return response(['message' => 'با موفقیت انجام شد.']);
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->isOwn() || $comment->isOwnMember()) {
            $comment->delete();
            return response(['message' => 'با موفقیت حذف شد.']);
        }
        return response(['message' => 'متاسفانه مشکلی رخ داده است.'],400);
    }

    public function members($room)
    {
        $room = Room::where('link',$room)->with('members')->firstOrFail();
        $room->created_at = Jalalian::forge($room->created_at);

        if(!(auth()->user()->hasRoom($room) && auth()->user()->type == 'teacher'))
            return abort(404);

        return view('Quizviran::panel.teacher.members',compact('room'));
    }

}
