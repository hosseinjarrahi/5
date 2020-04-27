<?php

namespace Quizviran\Repositories;

use App\Http\Upload;
use Quizviran\Models\Question;

class QuestionRepo
{
    public static function find($ids)
    {
      return Question::find($ids);
    }

    public static function findOrFail($question)
    {
      return Question::findOrFail($question);
    }

    public static function create($request)
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

    public static function update($request,$question)
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