@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت سوالات آزمون')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <div class="row px-5 my-3 justify-content-around justify-content-center">

            <div class="col-12 col-md-6">

                <app-main-box :dark="true" title="ایجاد سوال" icon="plus">

                        <form method="post" enctype="multipart/form-data" action="{{ url('/quiz/question') }}">
                            @csrf
                            <div class="form-group">
                                <select name="type" class="form-control">
                                    <option value="test">تستی</option>
                                    {{--                            <option value="descriptive">تشریحی</option>--}}
                                </select>
                            </div>
                            <div class="form-group">
                                <lable><span class="fas fa-paragraph"></span>توضیحات</lable>
                                <app-latex></app-latex>
                            </div>
                            <div class="form-group">
                                <label><span class="fas fa-check-square"></span> گزینه A </label>
                                <input class="form-control" name="A">
                            </div>
                            <div class="form-group">
                                <label><span class="fas fa-check-square"></span> گزینه B </label>
                                <input class="form-control" name="B">
                            </div>
                            <div class="form-group">
                                <label><span class="fas fa-check-square"></span> گزینه C </label>
                                <input class="form-control" name="C">
                            </div>
                            <div class="form-group">
                                <label><span class="fas fa-check-square"></span> گزینه D </label>
                                <input class="form-control" name="D">
                            </div>
                            <div class="form-group">
                                <label><span class="fas fa-star"></span> امتیاز سوال </label>
                                <input required type="number" class="form-control" name="norm">
                            </div>
                            <div class="form-group">
                                <label><span class="fas fa-check"></span> جواب </label>
                                <select name="answer" class="form-control">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1"><span class="fas fa-image"></span> تصویر </label>
                                <input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
                            </div>

                            <button class="btn btn-primary btn-block">افزودن سوال</button>
                        </form>
                </app-main-box>
            </div>

            <div class="col-12 col-md-6" style="margin-top: 55px;">

                <div class="px-1 my-4 px-md-5 col-12">
                    <app-content-border-box title="سوالات آزمون" icon="question">
                        <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">
                            @foreach($quiz->questions as $index => $question)
                                <div class="">
                                    <vue-mathjax formula="{{ ($index+1).' - '.$question->desc }}"></vue-mathjax>
                                    <div class="d-flex flex-row justify-content-center mt-3 bg-gray rounded align-items-center py-1">

                                        <div class="mx-1"><a class="badge badge-info" href="{{ url("/quiz/question/{$question->id}/edit") }}"
                                                             class="btn btn-primary">ویرایش</a></div>
                                        <div class="mx-1"><a class="badge badge-light" href="{{ url("/quiz/question/{$question->id}") }}">مشاهده سوال</a></div>
                                        <a class="badge badge-danger"
                                           href="{{ url("/quiz/question/{$question->id}/delete-from-exam?exam=".json_decode($quiz)->id) }}">حذف از آزمون</a>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>

                            @endforeach
                        </div>
                    </app-content-border-box>
                </div>

                <div class="px-1 my-4 px-md-5 col-12 mt-5">
                    <app-content-border-box title="تمامی سوالات شما" icon="question-circle">
                        <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">
                            @foreach($allQuestions as $index => $question)
                                <div class="">
                                    <vue-mathjax formula="{{ ($index+1).' - '.$question->desc }}"></vue-mathjax>
                                    <div class="d-flex flex-row justify-content-center mt-3 bg-gray rounded align-items-center py-1">

                                        <div class="mx-1"><a class="badge badge-info" href="{{ url("/quiz/question/{$question->id}/edit") }}"
                                                             class="btn btn-primary">ویرایش</a></div>
                                        <div class="mx-1"><a class="badge badge-light" href="{{ url("/quiz/question/{$question->id}") }}">مشاهده سوال</a></div>
                                    </div>
                                    <a class="btn py-0 bg-light btn-block"
                                       href="{{ url("/quiz/question/{$question->id}/add-to-exam?exam=".json_decode($quiz)->id) }}">افزودن به آزمون</a>
                                </div>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        </div>
                    </app-content-border-box>
                </div>
            </div>

        </div>


    </div>


@endsection
