<?php

namespace Quizviran\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Repositories\CommentRepo;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\RoomRepo;
use Illuminate\Support\Facades\File as FileFacade;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('has.room')->except([
            'create',
            'store',
            'deleteComment',
            'updateComment',
        ]);
    }

    public function create()
    {
        return view('Quizviran::panel.teacher.room.roomCreate');
    }

    public function show($room)
    {
        $room = RoomRepo::withCommentAndMemberCount($room);

        if (! auth()->user()->hasRoom($room)) {
            return abort(401);
        }

        $room->created_at = Jalalian::forge($room->created_at);

        $room->quizzes = $room->quizzes()->orderByDesc('id')->paginate(10);

        return view('Quizviran::panel.teacher.room.room', compact('room'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->isTeacher()) {
            return back();
        }

        [
            $link,
            $code,
        ] = $this->generateCode();

        $room = RoomRepo::create($request->name, $link, $code);

        return view('Quizviran::panel.teacher.room.roomCreated', compact('room'));
    }

    public function addComment(Request $request)
    {
        $room =  RoomRepo::findOrFail($request->id);

        if($room->gapLock) return response(['message' => 'گفت و گو قفل می باشد.'],400);

        $files = collect($request->post('files'));

        $files = File::find($files->pluck('id'));

        $comment = CommentRepo::create($request->only([
            'comment',
            'type',
            'id'
        ]));

        $comment->files()->saveMany($files);

        return response(['message' => 'با موفقیت اضافه شد']);
    }

    public function updateComment($comment, Request $request)
    {
        $comment = CommentRepo::findOrFail($comment);

        if (! $comment->isOwn()) {
            return response(['message' => 'این نظر قابل ویرایش نیست.'], 400);
        }

        CommentRepo::update($comment,$request);

        return response(['message' => 'با موفقیت انجام شد.']);
    }

    public function deleteComment($comment)
    {
        $comment = CommentRepo::findOrFail($comment);

        if ($comment->isOwn() || $comment->isOwnMember()) {
            FileFacade::delete(public_path($comment->files->pluck('file')));
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

        return view('Quizviran::panel.teacher.room.members', compact('room'));
    }

    public function lock($room)
    {
        $room = RoomRepo::findByLink($room);

        if (! auth()->user()->isTeacher()) {
            return back();
        }

        RoomRepo::toggleLock($room);

        return back();
    }

    public function gapLock($room)
    {
        $room = RoomRepo::findByLink($room);
        if (! auth()->user()->isTeacher()) {
            return back();
        }

        RoomRepo::toggleGap($room);

        return back();
    }

    private function generateCode()
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
