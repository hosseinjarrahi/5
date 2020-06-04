<?php

namespace Quizviran\Repositories;

use Quizviran\Models\Question;

class QuestionRepo
{
    // todo : refactore $request
    public static function find($ids)
    {
        return Question::find($ids);
    }

    public static function findOrFail($question)
    {
        return Question::findOrFail($question);
    }

    public static function create($request, $pic)
    {
        $question = new Question;

        self::setValues($question, $request, $pic);

        $question->user_id = auth()->id();

        $question->save();

        return $question;
    }

    public static function update($request, $question, $pic)
    {
        self::setValues($question, $request, $pic);

        $question->save();

        return $question;
    }

    private static function setValues(&$question, $request, $pic)
    {
        $question->A = $request['A'];
        $question->B = $request['B'];
        $question->D = $request['D'];
        $question->C = $request['C'];
        $question->answer = $request['answer'];
        $question->desc = $request['formula'];
        $question->type = $request['type'];
        $question->norm = $request['norm'];
        $question->level = $request['level'];
        $question->pic = $pic;
    }
}
