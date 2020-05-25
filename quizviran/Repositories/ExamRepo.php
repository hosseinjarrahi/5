<?php

namespace Quizviran\Repositories;

use Quizviran\Models\Quiz;
use Morilog\Jalali\Jalalian;

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

    public static function update($exam, $request)
    {
        // todo : remove jalalydate and use start
        $start = Jalalian::fromFormat('Y-m-d H:i:s', $request['jalalyDate'])->toCarbon();

        $quiz = self::findOrFail($exam);
        $quiz->name = $request['name'];
        $quiz->desc = $request['desc'];
        $quiz->start = $start;
        $quiz->duration = $request['duration'];
        $quiz->save();
    }

    public static function create($request)
    {
        $start = Jalalian::fromFormat('Y-m-d H:i:s', $request['start'])->toCarbon();

        $quiz = new Quiz();
        $quiz->name = $request['name'];
        $quiz->duration = $request['duration'];
        $quiz->start = $start;
        $quiz->desc = $request['desc'];
        $quiz->type = 'private';
        $quiz->show = 1;
        $quiz->user_id = auth()->id();
        $quiz->save();

        return $quiz;
    }

    public static function toggleShow($exam)
    {
        $exam->show = ! $exam->show;
        $exam->save();
    }

    public static function withQuestionsFindOrFail($exam)
    {
        return Quiz::with('questions')->findOrFail($exam);
    }

    public static function addDuration($quiz, $duration = 5)
    {
        $quiz->duration += $duration;
        $quiz->save();
    }
}
