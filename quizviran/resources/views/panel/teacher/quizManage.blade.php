@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت آزمون ها')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>


        <div class="row justify-content-center my-3">
            <div class="col-11 my-2 bg-dark-gray rounded">

                <div class="d-flex p-2 flex-md-row flex-column text-center">

                    <div class="p-1 bg-light mx-2 rounded d-none d-md-flex"></div>
                    <h2 class="p-0 m-0">{{ $room->name }}</h2>
                    <div class="dropdown-divider d-block d-md-none"></div>
                    <div class="d-flex ml-md-auto align-items-center flex-column flex-md-row ">
                        <div class="mx-3"><span>کد عضویت : </span><span>{{ $room->code }}</span></div>
                        <div class="dropdown-divider d-block d-md-none"></div>
                        <div class="mx-3"><span>تعداد اعضاء : </span><span>{{ $room->members()->count() }}</span></div>
                        <div class="dropdown-divider d-block d-md-none"></div>
                        <div class="mx-3"><span>ساخته شده در : </span><span>{{ $room->created_at->format('Y/m/d') }}</span></div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row px-2 px-md-5 justify-content-center mt-5">
            <div class="alert alert-info">
                آزمون ها با پسزمینه سبز تنها در سایت نمایش داده میشوند.
                در صورت حذف آزمون ، آزمون موجود خواهد بود با این تفاوت که در سایت قابل نمایش نیست.
            </div>
            <div class="col-11 col-md-6 mb-5 shadow rounded p-3">
                <app-quiz-make :room="{{ $room->id }}"></app-quiz-make>
            </div>
            <div class="col-11">
                <table class="text-center table table-responsive-sm table-striped table-hover">
                    <tr>
                        <td>نام آزمون</td>
                        <td>افزودن سوال</td>
                        <td>ویرایش</td>
                        <td>مشاهده آزمون</td>
                        <td>نتایج</td>
                        <td>تمدید (5 دقیقه)</td>
                        <td>حذف</td>
                    </tr>
                    @forelse($room->quizzes ?? [] as $quiz)
                        <tr @if($quiz->show) class="bg-success text-white" @endif>
                            <td class="col-12">{{ $quiz->name }}</td>
                            <td class="col-1"><a class="btn btn-info" href="{{ url('/quiz/exam/'.$quiz->id.'/manage-questions') }}">افزودن سوال</a></td>
                            <td class="col-1"><a class="btn btn-info" href="{{ url('/quiz/exam/'.$quiz->id.'/edit') }}">ویرایش</a></td>
                            <td class="col-1"><a class="btn btn-info" href="{{ url('/quiz/exam/'.$quiz->id) }}">مشاهده</a></td>
                            <td class="col-1"><a class="btn btn-info" href="{{ url('/quiz/exam/'.$quiz->id.'/results') }}">جزییات</a></td>
                            <td class="col-1">
                                <app-revival-button exam="{{ $quiz->id }}"></app-revival-button>
                            </td>
                            <td class="col-1">
                                <form method="post" action="{{ url('/quiz/exam/'.$quiz->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">
                                        @if($quiz->show)
                                            حذف
                                        @else
                                            نمایش
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">آزمونی وجود ندارد ...</td>
                        </tr>
                    @endforelse
                </table>
                {{--                {{ $room->quizzes->links() }}--}}
            </div>
        </div>
    </div>
@endsection
