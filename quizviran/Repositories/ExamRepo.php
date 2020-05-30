<?php

namespace Quizviran\Repositories;

use Quizviran\Models\Exam;
use Morilog\Jalali\Jalalian;

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
        // todo : remove jalalydate and use start
        $start = Jalalian::fromFormat('Y-m-d H:i', toStandardDatetime($request['jalalyDate']))->toCarbon();
        $exam = self::findOrFail($exam);
        $exam->name = $request['name'];
        $exam->desc = $request['desc'];
        $exam->start = $start;
        $exam->duration = $request['duration'];
        $exam->save();
    }

    public static function create($request)
    {
        $start = Jalalian::fromFormat('Y-m-d H:i', toStandardDatetime($request['start']))->toCarbon();

        $exam = new Exam();
        $exam->name = $request['name'];
        $exam->duration = $request['duration'];
        $exam->start = $start;
        $exam->desc = $request['desc'];
        $exam->type = 'private';
        $exam->show = 1;
        $exam->user_id = auth()->id();
        $exam->save();

        return $exam;
    }

    public static function toggleShow($exam)
    {
        $exam->show = ! $exam->show;
        $exam->save();
    }

    public static function withQuestionsFindOrFail($exam)
    {
        return Exam::with('questions')->findOrFail($exam);
    }

    public static function addDuration($exam, $duration = 5)
    {
        $exam->duration += $duration;
        $exam->save();
    }
}
