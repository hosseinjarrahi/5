<?php

namespace Quizviran\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Repositories\CommentRepo;
use Illuminate\Routing\Controller;
use Quizviran\Models\Comment;
use Quizviran\Models\Room;
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
            'okComments',
            'ok',
            'deleteC',
        ]);
    }

    public function create()
    {
        /**
         * @get('/quiz/panel/room/create')
         * @name('quizviran.room.create')
         * @middlewares(web, auth)
         */
        return view('Quizviran::panel.teacher.room.roomCreate');
    }

    public function deleteC(Comment $comment)
    {
        $comment->delete();

        return back();
    }

    public function ok(Comment $comment)
    {
        $comment->update(['show' => true]);

        return back();
    }

    public function okComments($room)
    {
        $room = RoomRepo::findByLink($room);

        $comments = $room->comments()->with(['user'])->where('show', false)->get();

        return view('Quizviran::panel.teacher.room.okComments',compact('comments','room'));
    }

    public function show($room)
    {
        /**
         * @get('/quiz/panel/room/{room}')
         * @name('quizviran.room.show')
         * @middlewares(web, auth, has.room)
         */
        $room = RoomRepo::withMemberCount($room);

        $comments = $room->comments()->where(['show' => true])->orderByDesc('id')->with([
            'files',
            'user',
        ])->paginate(10);

        if (!auth()->user()->hasRoom($room)) {
            return abort(401);
        }

        $room->exams = $room->exams()->show()->orderByDesc('id')->paginate(10);

        return view('Quizviran::panel.teacher.room.room', compact('room', 'comments'));
    }

    public function store(Request $request)
    {
        /**
         * @post('/quiz/panel/room')
         * @name('quizviran.room.store')
         * @middlewares(web, auth)
         */
        if (!auth()->user()->isTeacher()) {
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
        /**
         * @post('/quiz/panel/room/comment')
         * @name('quizviran.room.add.comment')
         * @middlewares(web, auth, has.room)
         */
        $room = RoomRepo::findOrFail($request->id);

        if ($room->gapLock) {
            return response(['message' => 'گفت و گو قفل می باشد.'], 400);
        }

        $files = collect($request->post('files'));

        $files = File::find($files->pluck('id'));

        $comment = CommentRepo::create($request->only([
            'comment',
            'type',
            'id',
        ]));

        $comment->files()->saveMany($files);

        $comment->load(['user', 'files']);

        return response([
            'message' => 'با موفقیت اضافه شد',
            'comment' => $comment,
        ]);
    }

    public function updateComment($comment, Request $request)
    {
        /**
         * @put('/quiz/panel/room/comment/{comment}')
         * @name('quizviran.room.update.comment')
         * @middlewares(web, auth)
         */
        $comment = CommentRepo::findOrFail($comment);

        if (!$comment->isOwn()) {
            return response(['message' => 'این نظر قابل ویرایش نیست.'], 400);
        }

        CommentRepo::update($comment, $request);

        return response(['message' => 'با موفقیت انجام شد.']);
    }

    public function deleteComment($comment)
    {
        /**
         * @delete('/quiz/panel/room/comment/{comment}')
         * @name('quizviran.room.delete.comment')
         * @middlewares(web, auth)
         */
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
        /**
         * @get('/quiz/panel/room/{room}/members')
         * @name('quizviran.room.members')
         * @middlewares(web, auth, has.room)
         */
        $room = RoomRepo::withMembersBylink($room);

        if (!auth()->user()->isTeacher()) {
            return abort(401);
        }

        return view('Quizviran::panel.teacher.room.members', compact('room'));
    }

    public function lock($room)
    {
        /**
         * @get('/quiz/panel/room/{room}/lock')
         * @name('quizviran.room.lock')
         * @middlewares(web, auth, has.room)
         */
        $room = RoomRepo::findByLink($room);

        if (!auth()->user()->isTeacher()) {
            return back();
        }

        RoomRepo::toggleLock($room);

        return back();
    }

    public function gapLock($room)
    {
        /**
         * @get('/quiz/panel/room/{room}/gap-lock')
         * @name('quizviran.room.gapLock')
         * @middlewares(web, auth, has.room)
         */
        $room = RoomRepo::findByLink($room);
        if (!auth()->user()->isTeacher()) {
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
