<?php

namespace Quizviran\Http\Controllers;

use Quizviran\Models\Quiz;
use Quizviran\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Http\Resources\QuizResourse;

class QuizController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function quizDetail(Quiz $quiz)
    {
        $users = $quiz->users()->withPivot(['norm'])->get();
        return view('quizDetail',compact('users','quiz'));
    }

    public function store(Request $request)
    {
        $quiz = new Quiz();
        $quiz->name = $request->name;
        $quiz->duration = $request->duration;
        $quiz->start = $request->start;
        $quiz->show = 1;
        if ($quiz->save()) {
            return response(['ok']);
        }

        return response(['error']);
    }

    public function show($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);

        if (! $quiz->show || ! $quiz->isInTime()) {
            return back();
        }

//        if(!$quiz->public /*todo : auth()->user()->hasQuiz($quiz)*/)

        $questions = $quiz->questions;
        $quiz = new QuizResourse($quiz);
        $quiz = json_decode($quiz->toJson());
        return view('Quizviran::quiz', compact('quiz', 'questions'));
    }

    public function destroy($quiz)
    {
        $quiz = Quiz::findOrFail($quiz);

        $quiz->show = 0;
        $quiz->save();

        return back();
    }

    public function complete(Request $request)
    {
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

    public function addQuestion(Request $request)
    {
        $quiz = Quiz::findOrFail($request->id);

        return view('admin.questionAdd', compact('quiz'));
    }

    public function add(Request $request)
    {
        $request->validate(['img' => 'mimes:jpg,png,jpeg,gif']);
        $quiz = Quiz::findOrFail($request->quizId);
        $question = $this->createQuestion($request);
        $quiz->questions()->save($question);
        return back();
    }

    private function createQuestion(Request $request)
    {
        $question = new Question;
        $question->A = $request->A;
        $question->B = $request->B;
        $question->D = $request->D;
        $question->C = $request->C;
        $question->answer = $request->answer;
        $question->desc = $request->desc;
        $question->type = $request->type;
        $question->norm = $request->norm;
        $question->pic = $this->uploadImgQuestion($request);
        return $question;
    }

    private function uploadImgQuestion(Request &$request)
    {
        $img = $request->file('img');
        $path = null;
        if ($request->hasFile('img') && ! is_null($request->img)) {
            $path = time() . random_int(10, 5000) . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('upload'), $path);
        }
        return $path ? 'upload/' . $path : null;
    }
}
