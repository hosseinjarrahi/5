<?php

namespace Quizviran\Http\Controllers;

use App\Http\Upload;
use Quizviran\Models\Quiz;
use Quizviran\Models\Question;
use Illuminate\Routing\Controller;

class QuestionController extends Controller
{
    public function __construct()
    {
        if (! auth()->check()) {
            return redirect('/');
        }
    }

    public function show($question)
    {
        $question = Question::findOrFail($question);

        return view('Quizviran::panel.teacher.question', compact('question'));
    }

    public function destroy()
    {

    }

    public function edit($question)
    {
        $question = Question::find($question);

        return view('Quizviran::panel.teacher.questionEdit', compact('question'));
    }

    public function update($question)
    {
        $question = Question::findOrFail($question);
        $request = request();
        $request->validate(['img' => 'mimes:jpg,png,jpeg,gif']);
        $this->updateQuestion($request, $question);

        return back();
    }

    public function addToExam($question)
    {
        $question = Question::findOrFail($question);
        $exam = Quiz::findOrFail(request()->exam);

        $exam->questions()->attach($question);

        return back();
    }

    public function deleteFromExam($question)
    {
        $question = Question::findOrFail($question);
        $exam = Quiz::findOrFail(request()->exam);

        $exam->questions()->detach($question);

        return back();
    }

    public function store()
    {
        $request = request();
        $request->validate(['img' => 'mimes:jpg,png,jpeg,gif']);
        $this->createQuestion($request);

        return back();
    }

    public function create()
    {
        return view('Quizviran::panel.teacher.questionAdd');
    }

    private function createQuestion($request)
    {
        $pic = Upload::uploadFile(['pic' => $request->img]);
        $pic = $pic ? $pic['pic'] : null;
        $question = new Question;
        $question->A = $request->A;
        $question->B = $request->B;
        $question->D = $request->D;
        $question->C = $request->C;
        $question->answer = $request->answer;
        $question->desc = $request->desc;
        $question->type = $request->type;
        $question->norm = $request->norm;
        $question->pic = $pic;
        $question->user_id = auth()->id();

        $question->save();
    }

    private function updateQuestion($request, $question)
    {
        $pic = Upload::uploadFile(['pic' => $request->pic]);
        $pic = $pic ? $pic : null;

        $question->A = $request->A;
        $question->B = $request->B;
        $question->D = $request->D;
        $question->C = $request->C;
        $question->answer = $request->answer;
        $question->desc = $request->desc;
        $question->type = $request->type;
        $question->norm = $request->norm;
        $question->pic = $pic ?? $question->pic;

        $question->save();
    }
}