<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Quizviran\Models\Quiz;
use Quizviran\Models\Room;
use Quizviran\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Http\Resources\QuizResourse;

class QuizController extends Controller
{
    public function __construct()
    {
        if (! auth()->check()) {
            return abort(404);
        }
    }

    public function exams($room)
    {
        $room = Room::with(['quizzes'])->where('link', $room)->first();

        if (! (auth()->user()->hasRoom($room) && auth()->user()->type == 'teacher')) {
            return back();
        }

        return view('Quizviran::panel.teacher.quizManage', compact('room'));
    }

    public function edit($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);

        return view('Quizviran::panel.teacher.quizEdit', compact('quiz'));
    }

    public function revival($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);
        $quiz->duration += 5;
        $quiz->save();

        return response(['message' => 'با موفقیت تمدید شد.']);
    }

    public function update($quiz)
    {
        $request = request();
        $quiz = Quiz::findOrFail($quiz);
        $quiz->name = $request->name;
        $quiz->desc = $request->desc;
        $quiz->start = $request->start;
        $quiz->duration = $request->duration;
        $quiz->save();

        return response(['message' => 'با موفقیت ویرایش شد.']);
    }

    public function store(Request $request)
    {
        $room = Room::with('user')->findOrFail($request->room);
        if (! auth()->user()->hasRoom($room)) {
            return response(['error']);
        }

        $quiz = new Quiz();
        $quiz->name = $request->name;
        $quiz->duration = $request->duration;
        $quiz->start = $request->start;
        $quiz->desc = $request->desc;
        $quiz->type = 'private';
        $quiz->show = 1;
        $quiz->user_id = auth()->id();

        if ($quiz->save()) {
            $room->quizzes()->save($quiz);

            return response(['ok']);
        }

        return response(['error']);
    }

    public function destroy($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);
        if (! (auth()->user()->type == 'teacher' && auth()->id() == $quiz->user_id)) {
            return back();
        }

        $quiz->show = ! $quiz->show;
        $quiz->save();

        return back();
    }

    public function quizDetail(Quiz $quiz)
    {
        $users = $quiz->users()->withPivot(['norm'])->get();

        return view('quizDetail', compact('users', 'quiz'));
    }

    public function result($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);
        $user = auth()->user();
        $users = $quiz->getQuizUsersWithNorms();

        return view('Quizviran::results', compact('users', 'user', 'quiz'));
    }

    public function show($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);

        if ((! $quiz->show || ! $quiz->isInTime()) && ! auth()->user()->type == 'teacher') {
            return back();
        }

//        if(!$quiz->public /*todo : auth()->user()->hasQuiz($quiz)*/)

        $questions = $quiz->questions;
        $quiz = new QuizResourse($quiz);
        $quiz = json_decode($quiz->toJson());

        return view('Quizviran::quiz', compact('quiz', 'questions'));
    }

    public function complete()
    {
        if (auth()->user()->type == 'teacher') {
            return response(['message' => 'شما به عنوان معلم نمی توانید امتیازی ثبت کنید. ']);
        }
        $request = request();
        $quiz = Quiz::findOrFail($request->id);
        $user = auth()->user();
        if (! $quiz->isInTime() || ! $user->canComplete($quiz->id)) {
            return response([
                'message' => 'زمان به اتمام رسیده است و یا یک بار در این مسابقه شرکت کرده اید.',
                'type' => 'error',
            ], 200);
        }
        $data = $request->data;
        $norm = $this->getNorm($data);
        if ($user->quizzes()->save($quiz)) {
            $user->quizzes()->updateExistingPivot($quiz->id, [
                'norm' => $norm,
                'answers' => json_encode($data),
            ]);

            return response([
                'message' => 'با موفقیت ثبت شد.',
                'type' => 'success',
            ], 200);
        }

        return response([
            'message' => 'مشکلی رخ داده است',
            'type' => 'error',
        ], 200);
    }

    private function getNorm($data)
    {
        $norm = 0;
        $data = collect($data);
        $qs = Question::find($data->pluck('id')->values());
        foreach ($data as $d) {
            $q = $qs->where('id', $d['id'])->first();
            if ($d['selected'] == ($q->answer ?? '')) {
                $norm += $q['norm'];
            }
        }

        return $norm;
    }

    public function addQuestion($request)
    {
        $request = request();
        $quiz = Quiz::findOrFail($request->id);

        return view('admin.questionAdd', compact('quiz'));
    }

    public function manageQuestions($exam)
    {
        $quiz = Quiz::with('questions')->findOrFail($exam);
        $allQuestions = auth()->user()->questions;

        return view('Quizviran::panel.teacher.questionsManage', compact('quiz', 'allQuestions'));
    }

}
