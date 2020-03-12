<?php

namespace App\Http\Controllers;

use App\Question;
use App\Http\Resources\QuizResourse;
use App\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
    }

    public function show(Quiz $quiz)
    {
        if (! $quiz->isInTime()) {
            return back();
        }
        $questions = ($quiz->questions)->toJson();
        $quiz = new QuizResourse($quiz);
        $quiz = json_decode($quiz->toJson());

        return view('quiz', compact('quiz', 'questions'));
    }

    public function edit(Quiz $quiz)
    {
        //
    }

    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    public function destroy(Quiz $quiz)
    {
        //
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
        $qs = Question::find($data->pluck('id'));
        dd($data->pluck('id')->values());
        foreach ($data as $d) {
            $q = $qs->where('id', $d['id'])->first();
            if ($d['selected'] == ($q['selected'] ?? '')) {
                $norm += $q['norm'];
            }
        }

        return $norm;
    }
}
