<?php

namespace App\Http\Middleware;

use Closure;
use Quizviran\Repositories\QuestionRepo;

class HasQuestion
{
    public function handle($request, Closure $next)
    {
        $question = QuestionRepo::findOrFail($request->route()->question);

        if(auth()->user()->hasQuestion($question->user_id))
            return $next($request);

        return abort(404);
    }
}
