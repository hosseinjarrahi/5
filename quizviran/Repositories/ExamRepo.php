<?php

namespace Quizviran\Repositories;

use Quizviran\Models\Exam;

class ExamRepo
{
    public static function publicShow()
    {
        return Exam::public()->show()->get();
    }

    public static function findOrFail($exam)
    {
        return Exam::findOrFail($exam);
    }

    public static function update($exam, $request)
    {
        $start = standardJalalyToCarbon($request);

        $exam->update([
            'name' => $request['name'],
            'desc' => $request['desc'],
            'start' => $start,
            'duration' => $request['duration'],
        ]);

        $exam->save();
    }

    public static function create($request)
    {
        $start = standardJalalyToCarbon($request);

        return Exam::create([
            'name' => $request['name'],
            'desc' => $request['desc'],
            'start' => $start,
            'duration' => $request['duration'],
            'type' => 'private',
            'show' => 1,
            'user_id' => auth()->id(),
        ]);
    }

    public static function toggleShow($exam)
    {
        $exam->show = ! $exam->show;
        $exam->save();
    }

    public static function withQuestionsAndRoom($exam)
    {
        return Exam::with(['questions','rooms'])->findOrFail($exam);
    }

    public static function addDuration($exam, $duration = 5)
    {
        $exam->duration += $duration;
        $exam->save();
    }

    public static function withQuestionsFindOrFail($exam)
    {
        return Exam::with(['questions'])->findOrFail($exam);
    }
}
