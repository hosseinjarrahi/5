<?php

namespace Quizviran\Repositories;

use Quizviran\Models\Quiz;

class ExamRepo
{
    public static function publicShow()
    {
        return Quiz::public()->show()->get();
    }

    public static function findOrFail($exam)
    {
        return Quiz::findOrFail($exam);
    }

    public static function update($exam,$update)
    {
        $quiz = self::findOrFail($exam);
        $quiz->name = $request->name;
        $quiz->desc = $request->desc;
        $quiz->start = $request->start;
        $quiz->duration = $request->duration;
        $quiz->save();
    }

    public static function create($request)
    {
        $quiz = new Quiz();
        $quiz->name = $request->name;
        $quiz->duration = $request->duration;
        $quiz->start = $request->start;
        $quiz->desc = $request->desc;
        $quiz->type = 'private';
        $quiz->show = 1;
        $quiz->user_id = auth()->id();
        $quiz->save();

        return $quiz;
    }

    public static function toggleShow($quiz)
    {
        $exam->show = ! $exam->show;
        $exam->save();
    }

    public static function withQuestionsFindOrFail($exam)
    {
        return Quiz::with('questions')->findOrFail($exam);
    }

    public static function addDuration5Min($quiz)
    {
        $quiz->duration += 5;
        $quiz->save();
    }
}