<?php

namespace Quizviran\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\ExamRepo;
use Quizviran\Repositories\QuestionRepo;
use Quizviran\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\File as FileFacade;

class QuestionController extends Controller
{
    private $picPath;

    public function __construct()
    {
        $this->middleware(['has.question'])->except([
            'store',
            'create',
            'deleteManyFromExam',
            'addManyToExam',
        ]);

        $this->picPath = 'public/quiz-pics/' . jalalyFolder();
    }

    public function create()
    {
        /**
         * @get('/quiz/question/create')
         * @name('quizviran.question.create')
         * @middlewares(web, auth)
         */
        return abort(404);
    }

    public function show($question)
    {
        /**
         * @get('/quiz/question/{question}')
         * @name('quizviran.question.show')
         * @middlewares(web, auth, has.question)
         */
        $question = QuestionRepo::findOrFail($question);

        return view('Quizviran::panel.teacher.question.question', compact('question'));
    }

    public function destroy()
    {
        /**
         * @delete('/quiz/question/{question}')
         * @name('quizviran.question.destroy')
         * @middlewares(web, auth, has.question)
         */
    }

    public function edit($question)
    {
        /**
         * @get('/quiz/question/{question}/edit')
         * @name('quizviran.question.edit')
         * @middlewares(web, auth, has.question)
         */
        $question = QuestionRepo::findOrFail($question);

        return view('Quizviran::panel.teacher.question.questionEdit', compact('question'));
    }

    public function update($question, QuestionRequest $request)
    {
        /**
         * @methods(PUT, PATCH)
         * @uri('/quiz/question/{question}')
         * @name('quizviran.question.update')
         * @middlewares(web, auth, has.question)
         */
        // todo : change validate for better ui
        $question = QuestionRepo::findOrFail($question);

        $pic = $this->storePic($request->pic);

        $pic = $pic ? $pic : $question->pic;

        $question = QuestionRepo::update($request->only([
            'A',
            'B',
            'D',
            'C',
            'answer',
            'desc',
            'type',
            'norm',
            'level',
            'category',
        ]), $question, $pic);
        // todo : check if user has this category
        $category = $request['category'] ? Category::findOrfail($request['category']) : null;

        if ($category) {
            $question->categories()->sync($category);
        }

        return response(['message' => 'با موفقیت ویرایش شد.']);

        return back();
    }

    public function store(QuestionRequest $request)
    {
        return response($request->all(),400);
        /**
         * @post('/quiz/question')
         * @name('quizviran.question.store')
         * @middlewares(web, auth)
         */
        $pic = $this->storePic($request->pic);

        $matched = Str::of($request->desc)->match('/<[^>]*script/');

        if ($matched) {
            return response([
                'message' => 'اطلاعات وارد شده شامل کاراکتر های غیر مجاز است.',
                400,
            ]);
        }

        $question = QuestionRepo::create($request->only([
            'A',
            'B',
            'D',
            'C',
            'answer',
            'desc',
            'type',
            'level',
            'norm',
            'category',
        ]), $pic);

        $category = $request['category'] ? Category::findOrfail($request['category']) : null;
        // todo : check if user has this category
        if ($category) {
            $question->categories()->sync($category);
        }

        return response(['message' => 'با موفقیت ایجاد شد.']);
    }

    public function addToExam($question)
    {
        /**
         * @get('/quiz/question/{question}/add-to-exam')
         * @name('quizviran.question.addTo.exam')
         * @middlewares(web, auth, has.question)
         */
        $question = QuestionRepo::findOrFail($question);

        $exam = ExamRepo::findOrFail(request()->exam);

        if (! $exam->questions->contains($question->id)) {
            $exam->questions()->attach($question);
        }

        return back();
    }

    public function deleteFromExam($question)
    {
        /**
         * @get('/quiz/question/{question}/delete-from-exam')
         * @name('quizviran.question.deleteFrom.exam')
         * @middlewares(web, auth, has.question)
         */
        // todo : check if exam is own
        $question = QuestionRepo::findOrFail($question);

        $exam = ExamRepo::findOrFail(request()->exam);

        $exam->questions()->detach($question);

        return back();
    }

    public function deleteManyFromExam(Request $request)
    {
        /**
         * @post('/quiz/question/delete-many-from-exam')
         * @name('quizviran.questions.deleteFrom.exam')
         * @middlewares(web, auth)
         */
        // todo check if exam and question is own
        $exam = ExamRepo::findOrFail($request->exam);

        $questions = QuestionRepo::findOrFail($request->questions);

        $exam->questions()->detach($questions);

        return response([
            'message' => 'با موفقیت ثبت شد',
        ]);
    }

    public function addManyToExam(Request $request)
    {
        /**
         * @post('/quiz/question/add-many-to-exam')
         * @name('quizviran.questions.addTo.exam')
         * @middlewares(web, auth)
         */
        $exam = ExamRepo::findOrFail(request()->exam);

        $questions = QuestionRepo::findOrFail($request->questions);

        $exam->questions()->syncWithoutDetaching($questions);

        return response([
            'message' => 'با موفقیت ثبت شد.',
        ]);
    }

    private function storePic($pic)
    {
        if (! $pic) {
            return null;
        }

        $mime = Str::of($pic)->before(';base64')->after('image/');
        $pic = base64_decode(Str::of($pic)->after('base64,'), true);

        if (! $pic) {
            return null;
        }

        $name = Str::random(15) . ".{$mime}";
        file_put_contents("temp/{$name}", $pic);
        FileFacade::ensureDirectoryExists(storage_path("app/{$this->picPath}"));
        FileFacade::move(public_path("temp\\{$name}"), storage_path("app/{$this->picPath}/{$name}"));

        return '/storage/' . ltrim($this->picPath, 'public/') . "/{$name}";
    }
}
