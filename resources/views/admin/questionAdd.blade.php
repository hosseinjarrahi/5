@extends('layout')
@section('title','مدیریت')

@section('content')
    .
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="alert alert-info">{{ $quiz->name }}</div>
                <form method="post" enctype="multipart/form-data" action="{{ route('question.add.post') }}">
                    @csrf
                    <div class="form-group">
                        <select name="type" class="form-control">
                            <option value="test">تستی</option>
                            <option value="descriptive">تشریحی</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable>توضیحات</lable>
                        <app-latex></app-latex>
                    </div>
                    <div class="form-group">
                        <label>گزینه A</label>
                        <input class="form-control" name="A">
                    </div>
                    <div class="form-group">
                        <label>گزینه B</label>
                        <input class="form-control" name="A">
                    </div>
                    <div class="form-group">
                        <label>گزینه C</label>
                        <input class="form-control" name="A">
                    </div>
                    <div class="form-group">
                        <label>گزینه D</label>
                        <input class="form-control" name="A">
                    </div>
                    <div class="form-group">
                        <label>امتیاز سوال</label>
                        <input required class="form-control" name="norm">
                    </div>
                    <div class="form-group">
                        <label>جواب</label>
                        <select name="type" class="form-control">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">تصویر</label>
                        <input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
                    </div>

                    <input type="hidden" name="quizId" value="{{ $quiz->id }}">

                    <button class="btn btn-primary btn-block">افزودن سوال</button>
                </form>
            </div>
        </div>
    </div>

@endsection
