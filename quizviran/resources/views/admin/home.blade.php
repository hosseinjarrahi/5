@extends('Quizviran::layout')
@section('title','مدیریت')

@section('content')
    .
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="alert alert-info">
                آزمون ها با پسزمینه سبز تنها در سایت نمایش داده میشوند.
                در صورت حذف آزمون آزمون موجود خواهد بود با این تفاوت که در سایت فابل نمایش نیست.
            </div>
            <div class="col-12 col-md-6 mb-5 shadow rounded p-3">
                <app-quiz-make></app-quiz-make>
            </div>
            <div class="col-12">
                <table class="text-center table table-responsive table-striped table-hover">
                    <tr>
                        <td>نام آزمون</td>
                        <td>افزودن سوال</td>
                        <td>جزییات</td>
                        <td>حذف</td>
                    </tr>
                    @foreach($quizzes as $quiz)
                        <tr @if($quiz->show) class="bg-success text-white" @endif>
                            <td class="col-12">{{ $quiz->name }}</td>
                            <td class="col-1"><a class="btn btn-info" href="{{ route('question.add',['id'=>$quiz->id]) }}">افزودن سوال</a></td>
                            <td class="col-1"><a class="btn btn-info" href="{{ url('admin/quiz/detail/'.$quiz->id) }}">بیشتر ...</a></td>
                            <td class="col-1">
                                <form method="post" action="{{ url('/quiz/'.$quiz->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $quizzes->links() }}
            </div>
        </div>
    </div>
@endsection
