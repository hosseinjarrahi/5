@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت سوالات آزمون')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>
        {{--   todo: make responsive     --}}
        <div class="row flex-nowrap bg-gray px-lg-3 align-items-center figure-caption text-light"
             style="height: 40px;overflow-x: auto;overflow-y: hidden;">

            <a href="{{ route('panel') }}" class="p-2">
                <span>پنل مدیریت</span>
            </a>
            <span class="fas fa-arrow-left"></span>

            <a href="{{ route('room.show',['room' => $room->link]) }}" class="p-2">
                <span>{{ $room->name }}</span>
            </a>
            <span class="fas fa-arrow-left"></span>

            <a href="{{ route('exam.manage',['room' => $room->link]) }}" class="p-2">
                <span>مدیریت آزمون ها</span>
            </a>
            <span class="fas fa-arrow-left"></span>

            <span class="p-2">
                <span>مدیریت سوالات</span>
            </span>

        </div>

        <div class="row my-3 justify-content-around justify-content-center">
            <div class="col-12 px-2 px-lg-5 col-lg-6">
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
                                <label><span class="fas fa-paragraph"></span>توضیحات</label>
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
                <div class="px-2 my-4 px-lg-5 col-12">
                    <app-question-exam name="{{ $exam->name }}" :questions="{{ $exam->questions->toJson() }}" id="{{ $exam->id }}"></app-question-exam>
                </div>

                <div class="px-1 my-4 px-lg-5 col-12 mt-5">
                    <app-question-all :questions="{{ $allQuestions->toJson() }}" id="{{ $exam->id }}"></app-question-all>
                </div>
            </div>
        </div>


    </div>


@endsection

