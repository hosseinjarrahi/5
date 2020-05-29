<?php

namespace Quizviran\Http\Controllers;

use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
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
        /** 
         * @get('/quiz/exam/{exam}')
         * @name('exam.show')
         * @middlewares(web, auth, has.exam)
         */
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
        /** 
         * @get('/quiz/exam/{exam}/edit')
         * @name('exam.edit')
         * @middlewares(web, auth, has.exam)
         */
        // todo make type cast to jalalian
        $quiz = ExamRepo::findOrFail($exam);
        $quiz->jalalyDate = $quiz->jalaly->format('Y-m-d H:i');

        return view('Quizviran::panel.teacher.exam.examEdit', compact('quiz'));
    }

    public function update($exam, Request $request)
    {
        /** 
         * @methods(PUT, PATCH)
         * @uri('/quiz/exam/{exam}')
         * @name('exam.update')
         * @middlewares(web, auth, has.exam)
         */
        ExamRepo::update($exam, $request->only([
            'name',
            'desc',
            'jalalyDate',
            'duration',
        ]));

        return response(['message' => 'با موفقیت ویرایش شد.']);
    }

    public function store(Request $request)
    {
        /** 
         * @post('/quiz/exam')
         * @name('exam.store')
         * @middlewares(web, auth)
         */
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
        /** 
         * @delete('/quiz/exam/{exam}')
         * @name('exam.destroy')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::findOrFail($exam);

        ExamRepo::toggleShow($exam);

        return back();
    }

    public function result($exam)
    {
        /** 
         * @get('/quiz/results/{exam}')
         * @name('')
         * @middlewares(web, auth, has.exam)
         */
        $quiz = ExamRepo::findOrFail($exam);
        $users = $quiz->getQuizUsersWithNorms();
        $room = $quiz->rooms()->first();

        return view('Quizviran::results', compact('users', 'user', 'quiz', 'room'));
    }

    public function complete(Request $request)
    {
        /** 
         * @post('/quiz/complete')
         * @name('')
         * @middlewares(web, auth)
         */
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
        /** 
         * @get('/quiz/exam/{exam}/manage-questions')
         * @name('')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::withQuestionsFindOrFail($exam);

        $allQuestions = auth()->user()->questions;

        $room = $exam->rooms()->firstOrFail();

        return view('Quizviran::panel.teacher.question.questionsManage', compact('room', 'quiz', 'allQuestions', 'exam'));
    }

    public function completeResult($exam)
    {
        /** 
         * @get('/quiz/exam/{exam}/results')
         * @name('')
         * @middlewares(web, auth, has.exam)
         */
        $quiz = ExamRepo::withQuestionsFindOrFail($exam);

        $users = $quiz->getQuizUsersWithPivot();

        return view('Quizviran::panel.teacher.exam.results', compact('users', 'quiz'));
    }

    // TODO : pdf
    public function pdf($exam)
    {
        /** 
         * @get('/quiz/exam/{exam}/pdf')
         * @name('')
         * @middlewares(web, auth, has.exam)
         */
        $quiz = ExamRepo::withQuestionsFindOrFail($exam);
        $users = $quiz->getQuizUsersWithPivot();
        if (request()->test) {
            return view('Quizviran::panel.teacher.exam.pdf', compact('quiz', 'users'));
        }
        $pdf = Pdf::loadView('Quizviran::panel.teacher.exam.pdf', compact('quiz', 'users'));

        return $pdf->stream('document.pdf');
    }

    public function revival($exam, Request $request)
    {
        /** 
         * @post('/quiz/exam/{exam}/revival')
         * @name('')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::findOrFail($exam);

        $duration = $request->sub == 'sub' ? -5 : 5;

        ExamRepo::addDuration($exam, $duration);

        return response(['message' => 'با موفقیت تمدید شد.']);
    }

    public function exams($room)
    {
        /** 
         * @get('/quiz/panel/room/{room}/exams')
         * @name('exam.manage')
         * @middlewares(web, auth)
         */
        $room = RoomRepo::getWithQuizzes($room);

        if (! auth()->user()->teacherHasRoom($room)) {
            return back();
        }

        return view('Quizviran::panel.teacher.exam.examManage', compact('room'));
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
