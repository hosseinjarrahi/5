<?php

namespace Quizviran\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\ExamRepo;
use Quizviran\Repositories\QuestionRepo;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this
            ->middleware(['has.question'])
            ->except(['store','create','deleteManyFromExam','addManyToExam']);
    }

    public function create()
    {
        /**
         * @get('/quiz/question/create')
         * @name('quizviran.question.create')
         * @middlewares(web, auth)
         */
        return abort(404);
    }

    public function show($question)
    {
        /**
         * @get('/quiz/question/{question}')
         * @name('quizviran.question.show')
         * @middlewares(web, auth, has.question)
         */
        $question = QuestionRepo::findOrFail($question);

        return view('Quizviran::panel.teacher.question.question', compact('question'));
    }

    public function destroy()
    {
        /**
         * @delete('/quiz/question/{question}')
         * @name('quizviran.question.destroy')
         * @middlewares(web, auth, has.question)
         */

    }

    public function edit($question)
    {
        /**
         * @get('/quiz/question/{question}/edit')
         * @name('quizviran.question.edit')
         * @middlewares(web, auth, has.question)
         */
        $question = QuestionRepo::findOrFail($question);

        return view('Quizviran::panel.teacher.question.questionEdit', compact('question'));
    }

    public function update($question, Request $request)
    {
        /**
         * @methods(PUT, PATCH)
         * @uri('/quiz/question/{question}')
         * @name('quizviran.question.update')
         * @middlewares(web, auth, has.question)
         */
        // todo : change validate for better ui
        $request->validate(['img' => 'mimes:jpg,png,jpeg,gif']);

        $question = QuestionRepo::findOrFail($question);

        $this->updateQuestion($request, $question);

        return back();
    }

    public function store(Request $request)
    {
        /**
         * @post('/quiz/question')
         * @name('quizviran.question.store')
         * @middlewares(web, auth)
         */
        // todo : this
        $request->validate(['img' => 'mimes:jpg,png,jpeg,gif']);

        QuestionRepo::create($request);

        return back();
    }

    private function updateQuestion($request, $question)
    {
        QuestionRepo::update($request,$question);

        return back();
    }

    public function addToExam($question)
    {
        /**
         * @get('/quiz/question/{question}/add-to-exam')
         * @name('quizviran.question.addTo.exam')
         * @middlewares(web, auth, has.question)
         */
        $question = QuestionRepo::findOrFail($question);

        $exam = ExamRepo::findOrFail(request()->exam);

        if (!$exam->questions->contains($question->id)) {
            $exam->questions()->attach($question);
        }

        return back();
    }

    public function deleteFromExam($question)
    {
        /**
         * @get('/quiz/question/{question}/delete-from-exam')
         * @name('quizviran.question.deleteFrom.exam')
         * @middlewares(web, auth, has.question)
         */
        // todo : check if exam is own
        $question = QuestionRepo::findOrFail($question);

        $exam = ExamRepo::findOrFail(request()->exam);

        $exam->questions()->detach($question);

        return back();
    }

    public function deleteManyFromExam(Request $request)
    {
        /**
         * @post('/quiz/question/delete-many-from-exam')
         * @name('quizviran.questions.deleteFrom.exam')
         * @middlewares(web, auth)
         */
        // todo check if exam and question is own
        $exam = ExamRepo::findOrFail($request->exam);

        $questions = QuestionRepo::findOrFail($request->questions);

        $exam->questions()->detach($questions);

        return response([
            'message' => 'با موفقیت ثبت شد'
        ]);
    }


    public function addManyToExam(Request $request)
    {
        /**
         * @post('/quiz/question/add-many-to-exam')
         * @name('quizviran.questions.addTo.exam')
         * @middlewares(web, auth)
         */
        $exam = ExamRepo::findOrFail(request()->exam);

        $questions = QuestionRepo::findOrFail($request->questions);

        $exam->questions()->sync($questions);

        return response([
            'message' => 'با موفقیت ثبت شد.'
        ]);
    }


}
