@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت سوالات آزمون')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <div class="row justify-content-center">
            <a href="{{ url('/quiz/question/create') }}" class="bg-gray text-light p-2 text-center col-12">
                <span class="fas fa-plus"></span>
                <span>افزودن سوال</span>
            </a>
        </div>

        <div class="row px-5 my-3 justify-content-around justify-content-center">
            <div class="px-1 my-4 px-md-5 col-12 col-md-6">
                <app-content-border-box title="سوالات آزمون">
                    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">
                        @foreach($quiz->questions as $index => $question)
                            <div class="">
                                <div>{{ ($index+1).' - '.$question->desc }}</div>
                                <div class="d-flex flex-row justify-content-center mt-3 bg-gray rounded align-items-center py-1">

                                    <div class="mx-1"><a class="badge badge-info" href="{{ url("/quiz/question/{$question->id}/edit") }}"
                                                         class="btn btn-primary">ویرایش</a></div>
                                    <div class="mx-1"><a class="badge badge-light" href="{{ url("/quiz/question/{$question->id}") }}">مشاهده سوال</a></div>
                                    <a class="badge badge-danger" href="{{ url("/quiz/question/{$question->id}/delete-from-exam?exam=".json_decode($quiz)->id) }}">حذف از آزمون</a>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>

                        @endforeach
                    </div>
                </app-content-border-box>
            </div>

            <div class="px-1 my-4 px-md-5 col-12 col-md-6">
                <app-content-border-box title="تمامی سوالات شما">
                    <div class="bg-dark-gray p-2 p-md-3 my-2 rounded">
                        @foreach($allQuestions as $index => $question)
                            <div class="">
                                <div>{{ ($index+1).' - '.$question->desc }}</div>
                                <div class="d-flex flex-row justify-content-center mt-3 bg-gray rounded align-items-center py-1">

                                    <div class="mx-1"><a class="badge badge-info" href="{{ url("/quiz/question/{$question->id}/edit") }}"
                                                         class="btn btn-primary">ویرایش</a></div>
                                    <div class="mx-1"><a class="badge badge-light" href="{{ url("/quiz/question/{$question->id}") }}">مشاهده سوال</a></div>
                                </div>
                                <a class="btn py-0 bg-light btn-block" href="{{ url("/quiz/question/{$question->id}/add-to-exam?exam=".json_decode($quiz)->id) }}">افزودن به آزمون</a>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endforeach
                    </div>
                </app-content-border-box>
            </div>
        </div>

    </div>
@endsection
