<?php

namespace Quizviran\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\RoomRepo;
use Quizviran\Repositories\ExamRepo;
use Quizviran\Repositories\QuestionRepo;
use Quizviran\Http\Resources\QuizResourse;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['has.exam'])->except([
            'store',
            'exams',
            'complete',
        ]);
    }

    public function show($exam)
    {
        $quiz = ExamRepo::findOrFail($exam);
        if (! $quiz->showableForMembers()) {
            return back();
        }

        $questions = $quiz->questions;
        $questions = $questions->shuffle();
        $quiz = new QuizResourse($quiz);
        $quiz = json_decode($quiz->toJson());

        return view('Quizviran::quiz', compact('quiz', 'questions'));
    }

    public function edit($exam)
    {
        $quiz = ExamRepo::findOrFail($exam);

        return view('Quizviran::panel.teacher.quizEdit', compact('quiz'));
    }

    public function update($exam, Request $request)
    {
        ExamRepo::update($exam, $request->only([
            'name',
            'desc',
            'start',
            'duration',
        ]));

        return response(['message' => 'با موفقیت ویرایش شد.']);
    }

    public function store(Request $request)
    {
        $room = RoomRepo::withUserFindOrFail($request->room);

        if (! auth()->user()->teacherHasRoom($room)) {
            return abort(404);
        }

        $quiz = ExamRepo::create($request->only([
            'name',
            'desc',
            'start',
            'duration',
        ]));

        $room->quizzes()->attach($quiz);

        return response(['ok']);
    }

    public function destroy($exam)
    {
        $exam = ExamRepo::findOrFail($exam);

        ExamRepo::toggleShow($exam);

        return back();
    }

    public function result($exam)
    {
        $quiz = ExamRepo::findOrFail($exam);
        $users = $quiz->getQuizUsersWithNorms();

        return view('Quizviran::results', compact('users', 'user', 'quiz'));
    }

    public function complete(Request $request)
    {
        if (auth()->user()->isTeacher()) {
            return response(['message' => 'شما به عنوان معلم نمی توانید امتیازی ثبت کنید. ']);
        }

        $quiz = ExamRepo::findOrFail($request->id);
        $user = auth()->user();

        if (! $this->userCanCompleteQuiz($quiz)) {
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

    public function manageQuestions($exam)
    {
        $quiz = ExamRepo::withQuestionsFindOrFail($exam);

        $allQuestions = auth()->user()->questions;

        return view('Quizviran::panel.teacher.questionsManage', compact('quiz', 'allQuestions'));
    }

    public function completeResult($exam)
    {
        $quiz = ExamRepo::withQuestionsFindOrFail($exam);

        $users = $quiz->getQuizUsersWithPivot();

        return view('Quizviran::panel.teacher.results', compact('users', 'quiz'));
    }
    // TODO : pdf
    public function pdf($exam)
    {
        $quiz = ExamRepo::withQuestionsFindOrFail($exam);
        $users = $quiz->getQuizUsersWithPivot();
        if (request()->test) {
            return view('Quizviran::panel.teacher.pdf', compact('quiz', 'users'));
        }
        $pdf = Pdf::loadView('Quizviran::panel.teacher.pdf', compact('quiz', 'users'));

        return $pdf->stream('document.pdf');
    }

    public function revival($exam,Request $request)
    {
        $exam = ExamRepo::findOrFail($exam);

        $duration = $request->sub == 'sub' ? -5 : 5;

        ExamRepo::addDuration($exam,$duration);

        return response(['message' => 'با موفقیت تمدید شد.']);
    }

    public function exams($room)
    {
        $room = RoomRepo::getWithQuizzes($room);

        if (! auth()->user()->teacherHasRoom($room)) {
            return back();
        }

        return view('Quizviran::panel.teacher.quizManage', compact('room'));
    }

    private function getNorm($data)
    {
        $norm = 0;
        $data = collect($data);
        $qs = QuestionRepo::find($data->pluck('id')->values());

        foreach ($data as $d) {
            $q = $qs->where('id', $d['id'])->first();
            $norm += ($d['selected'] == ($q->answer ?? '')) ? $q['norm'] : 0;
        }

        return $norm;
    }

    private function userCanCompleteQuiz($quiz): bool
    {
        return ($quiz->isInTime() && auth()->user()->canComplete($quiz->id));
    }

}
