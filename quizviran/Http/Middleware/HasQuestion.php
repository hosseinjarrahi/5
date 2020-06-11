<?php

namespace Quizviran\Http\Middleware;

use Closure;
use Quizviran\Repositories\QuestionRepo;

class HasQuestion
{
    public function handle($request, Closure $next)
    {
        $question = QuestionRepo::findOrFail($request->route()->question);

        if(cache('user')->hasQuestion($question->user_id))
            return $next($request);

        return abort(404);
    }
}
