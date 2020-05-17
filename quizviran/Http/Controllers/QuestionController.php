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
        $this->middleware(['has.question'])->except(['store','create']);
    }

    public function show($question)
    {
        $question = QuestionRepo::findOrFail($question);

        return view('Quizviran::panel.teacher.question.question', compact('question'));
    }

    public function destroy()
    {

    }

    public function edit($question)
    {
        $question = QuestionRepo::findOrFail($question);

        return view('Quizviran::panel.teacher.question.questionEdit', compact('question'));
    }

    public function update($question, Request $request)
    {
        // todo : change validate for better ui
        $request->validate(['img' => 'mimes:jpg,png,jpeg,gif']);

        $question = QuestionRepo::findOrFail($question);

        $this->updateQuestion($request, $question);

        return back();
    }

    public function store(Request $request)
    {
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
        $question = QuestionRepo::findOrFail($question);

        $exam = ExamRepo::findOrFail(request()->exam);

        if (!$exam->questions->contains($question->id)) {
            $exam->questions()->attach($question);
        }

        return back();
    }

    public function deleteFromExam($question)
    {
        $question = QuestionRepo::findOrFail($question);

        $exam = ExamRepo::findOrFail(request()->exam);

        $exam->questions()->detach($question);

        return back();
    }

}
