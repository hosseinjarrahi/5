@extends('Quizviran::layout')
@section('title','نیزویران | افزودن سوال')

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="px-5 text-right bg-gray col-12 py-2">
                <a href="{{ url()->previous() }}" class="w-100 text-light">
                    <span>بازگشت</span>
                    <span class="fas fa-arrow-left"></span>
                </a>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-8">
                <form method="post" enctype="multipart/form-data" action="{{ url('/quiz/question') }}">
                    @csrf
                    <div class="form-group">
                        <select name="type" class="form-control">
                            <option value="test">تستی</option>
{{--                            <option value="descriptive">تشریحی</option>--}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label><span class="fas fa-paragraph"></span>توضیحات </label>
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
            </div>
        </div>
    </div>

@endsection
