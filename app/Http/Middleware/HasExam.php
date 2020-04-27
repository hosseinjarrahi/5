<?php

namespace App\Http\Middleware;

use Closure;
use Quizviran\Repositories\ExamRepo;

class HasExam
{
    public function handle($request, Closure $next)
    {
        $exam = ExamRepo::findOrFail($request->route()->exam);

        if (auth()->user()->hasExam($exam) || $exam->isPublic()) {
            return $next($request);
        }

        return abort(404);
    }
}
