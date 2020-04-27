<?php

namespace Quizviran\Http\Controllers;

use App\Models\File;
use App\Models\Comment;
use Quizviran\Models\Room;
use Illuminate\Http\Request;
use App\Repositories\CommentRepo;
use Illuminate\Routing\Controller;
use Morilog\Jalali\Jalalian;
use Quizviran\Repositories\RoomRepo;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('has.room')->except([
            'create',
            'store',
        ]);
    }

    public function create()
    {
        return view('Quizviran::panel.teacher.roomCreate');
    }

    public function show($room)
    {
        $room = RoomRepo::withCommentAndMemberCount($room);

        if (! auth()->user()->hasRoom($room)) {
            return abort(401);
        }

        $room->created_at = Jalalian::forge($room->created_at);

        $room->quizzes = $room->quizzes()->orderByDesc('id')->paginate(10);

        return view('Quizviran::panel.teacher.room', compact('room'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->isTeacher()) {
            return back();
        }

        [
            $link,
            $code,
        ] = $this->generateCode($room2);

        $room = RoomRepo::create($request->name, $link, $code);

        return view('Quizviran::panel.teacher.roomCreated', compact('room'));
    }

    public function addComment(Request $request)
    {
        $files = collect($request->post('files'));

        $files = File::find($files->pluck('id'));

        $comment = CommentRepo::create($request);

        $comment->files()->saveMany($files);

        return response(['message' => 'با موفقیت اضافه شد']);
    }

    public function updateComment(Comment $comment, Request $request)
    {
        if (! $comment->isOwn()) {
            return response(['message' => 'این نظر قابل ویرایش نیست.'], 400);
        }
        $comment->comment = $request->comment;
        $comment->save();

        return response(['message' => 'با موفقیت انجام شد.']);
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->isOwn() || $comment->isOwnMember()) {
            \Illuminate\Support\Facades\File::delete(public_path($comment->files->pluck('file')));
            $comment->delete();

            return response(['message' => 'با موفقیت حذف شد.']);
        }

        return response(['message' => 'متاسفانه مشکلی رخ داده است.'], 400);
    }

    public function members($room)
    {
        $room = RoomRepo::withMembersBylink($room);

        $room->created_at = Jalalian::forge($room->created_at);

        if (! auth()->user()->isTeacher()) {
            return abort(401);
        }

        return view('Quizviran::panel.teacher.members', compact('room'));
    }

    public function lock($room)
    {
        $room = RoomRepo::findOrFail($room);

        if (! auth()->user()->isTeacher()) {
            return back();
        }

        RoomRepo::toggleLock($room);

        return back();
    }

    public function gapLock($room)
    {
        $room = Room::findOrFail($room);
        if (! auth()->user()->isTeacher()) {
            return back();
        }

        RoomRepo::toggleGap($room);

        return back();
    }

    private function generateCode($room2): array
    {
        $room1 = true;
        while ($room1 || $room2) {
            $link = \Str::random(10);
            $code = random_int(100000, 999999);
            $room1 = RoomRepo::findByLink($link);
            $room2 = RoomRepo::findByCode($code);
        }

        return [
            $link,
            $code,
        ];
    }
}
