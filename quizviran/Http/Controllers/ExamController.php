<?php

namespace Quizviran\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\RoomRepo;
use Quizviran\Repositories\ExamRepo;
use Quizviran\Repositories\QuestionRepo;
use Quizviran\Http\Requests\ExamRequest;
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
         * @name('quizviran.exam.show')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::findOrFail($exam);
        if (! $exam->showableForMembers()) {
            return back();
        }

        $questions = $exam->questions;
        $questions = $questions->shuffle();

        return view('Quizviran::exam', compact('exam', 'questions'));
    }

    public function edit($exam)
    {
        /**
         * @get('/quiz/exam/{exam}/edit')
         * @name('quizviran.exam.edit')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::findOrFail($exam);

        return view('Quizviran::panel.teacher.exam.examEdit', compact('exam'));
    }

    public function update($exam, ExamRequest $request)
    {
        /**
         * @methods(PUT, PATCH)
         * @uri('/quiz/exam/{exam}')
         * @name('quizviran.exam.update')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::findOrFail($exam);

        ExamRepo::update($exam, $request->only([
            'name',
            'desc',
            'start',
            'duration',
        ]));

        return response(['message' => 'با موفقیت ویرایش شد.']);
    }

    public function store(ExamRequest $request)
    {
        /**
         * @post('/quiz/exam')
         * @name('quizviran.exam.store')
         * @middlewares(web, auth)
         */
        $room = RoomRepo::withUserFindOrFail($request->room);

        if (! auth()->user()->teacherHasRoom($room)) {
            return abort(404);
        }

        $exam = ExamRepo::create($request->only([
            'name',
            'desc',
            'start',
            'duration',
        ]));

        $room->exams()->attach($exam);

        return response(['message' => 'با موفقیت اضافه شد.','exam' => $exam]);
    }

    public function destroy($exam)
    {
        /**
         * @delete('/quiz/exam/{exam}')
         * @name('quizviran.exam.destroy')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::findOrFail($exam);

        ExamRepo::toggleShow($exam);

        return response(['message' => 'با موفقیت انجام شد.']);
    }

    public function result($exam)
    {
        /**
         * @get('/quiz/results/{exam}')
         * @name('quizviran.exam.result.student')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::findOrFail($exam);
        $users = $exam->getExamUsersWithNorms();
        $room = $exam->rooms()->first();

        return view('Quizviran::results', compact('users', 'user', 'exam', 'room'));
    }

    public function complete(Request $request)
    {
        /**
         * @post('/quiz/complete')
         * @name('quizviran.exam.complete')
         * @middlewares(web, auth)
         */
        $user = auth()->user();

        if ($user->isTeacher()) {
            return response(['message' => 'شما به عنوان معلم نمی توانید امتیازی ثبت کنید. ']);
        }

        $exam = ExamRepo::findOrFail($request->id);

        if (! $this->userCanCompleteExam($exam)) {
            return response([
                'message' => 'زمان به اتمام رسیده است و یا یک بار در این آزمون شرکت کرده اید.',
                'type' => 'error',
            ], 200);
        }

        $data = $request->data;
        $norm = $this->getNorm($data);
        if ($user->exams()->save($exam)) {
            $user->exams()->updateExistingPivot($exam->id, [
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
         * @name('quizviran.questions.manage')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::withQuestionsAndRoom($exam);

        $questionsWithoutCategory = auth()->user()->questions()->whereDoesntHave('categories')->get();

        $room = $exam->rooms->first();

        $categories = auth()->user()->categories()->with('questions')->get();

        return view('Quizviran::panel.teacher.question.questionsManage', compact('categories', 'room', 'quiz', 'questionsWithoutCategory', 'exam'));
    }

    public function completeResult($exam)
    {
        /**
         * @get('/quiz/exam/{exam}/results')
         * @name('quizviran.exam.result.teacher')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::withQuestionsAndRoom($exam);

        $users = $exam->getExamUsersWithPivot();

        return view('Quizviran::panel.teacher.exam.results', compact('users', 'exam'));
    }

    // TODO : pdf
    public function pdf($exam)
    {
        /**
         * @get('/quiz/exam/{exam}/pdf')
         * @name('quizviran.exam.pdf')
         * @middlewares(web, auth, has.exam)
         */
        $exam = ExamRepo::withQuestionsFindOrFail($exam);
        $users = $exam->getExamUsersWithPivot();
        if (request()->test) {
            return view('Quizviran::panel.teacher.exam.pdf', compact('exam', 'users'));
        }
        $pdf = Pdf::loadView('Quizviran::panel.teacher.exam.pdf', compact('exam', 'users'));

        return $pdf->stream('document.pdf');
    }

    public function revival($exam, Request $request)
    {
        /**
         * @post('/quiz/exam/{exam}/revival')
         * @name('quizviran.exam.revival')
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
         * @name('quizviran.exam.manage')
         * @middlewares(web, auth)
         */
        $room = RoomRepo::getWithExams($room);

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

    private function userCanCompleteExam($exam): bool
    {
        return ($exam->isInTime() && auth()->user()->canComplete($exam->id));
    }
}
