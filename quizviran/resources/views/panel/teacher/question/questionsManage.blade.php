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
                    <app-question-exam :questions="{{ $quiz->questions->toJson() }}" id="{{ $quiz->id }}"></app-question-exam>
                </div>

                <div class="px-1 my-4 px-md-5 col-12 mt-5">
                    <app-question-all :questions="{{ $allQuestions->toJson() }}" id="{{ $quiz->id }}"></app-question-all>
                </div>
            </div>

        </div>


    </div>


@endsection
<script>
    import AppQuestionExam from "../../../../js/components/AppQuestionExam";
    import AppQuestionAll from "../../../../js/components/AppQuestionAll";
    export default {
        components: {AppQuestionAll, AppQuestionExam}
    }
</script>
