@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت آزمون ها')

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

            <span class="p-2">
                <span>مدیریت آزمون ها</span>
            </span>


        </div>

        <div class="row px-2 px-md-5 justify-content-center mt-5">
            <div class="col-11 col-md-6 mb-5 p-3">
                <app-exam-make :room="{{ $room->id }}"></app-exam-make>
            </div>
            <div class="col-11">
                <app-main-box :dark="true" title="آزمون های شما" icon="align-right">
                    <div class="alert alert-info">
                        آزمون هایی که پسزمینه آبی دارند برای دانش آموزان قابل نمایش هستند.
                    </div>


                    <table class="text-center table table-responsive-sm table-striped">
                        <tr>
                            <td>عنوان آزمون</td>
                            <td><span class="fas fa-plus"></span> <span>افزودن سوال</span></td>
                            <td><span class="fas fa-edit"></span> <span>ویرایش</span></td>
                            <td><span class="fas fa-eye"></span> <span>مشاهده آزمون</span></td>
                            <td><span class="fas fa-poll"></span> <span>نتایج</span></td>
                            <td><span class="fas fa-stamp"></span> <span>تمدید (5 دقیقه)</span></td>
                            <td><span class="fas fa-recycle"></span> <span>نمایش</span></td>
                        </tr>
                        @forelse($room->quizzes ?? [] as $quiz)
                            <tr class="@if($quiz->show) bg-info @else bg-dark-gray @endif">
                                <td>{{ $quiz->name }}</td>
                                <td><a class="btn btn-sm dark-shadow btn-light" href="{{ url('/quiz/exam/'.$quiz->id.'/manage-questions') }}">افزودن سوال</a></td>
                                <td><a class="btn btn-sm dark-shadow btn-light" href="{{ url('/quiz/exam/'.$quiz->id.'/edit') }}">ویرایش</a></td>
                                <td><a class="btn btn-sm dark-shadow btn-light" href="{{ url('/quiz/exam/'.$quiz->id) }}">مشاهده</a></td>
                                <td><a class="btn btn-sm dark-shadow btn-light" href="{{ url('/quiz/exam/'.$quiz->id.'/results') }}">جزییات</a></td>
                                <td>
                                    <app-revival-button exam="{{ $quiz->id }}"></app-revival-button>
                                </td>
                                <td>
                                    <form method="post" action="{{ url('/quiz/exam/'.$quiz->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="dark-shadow btn btn-sm btn-danger">
                                            @if($quiz->show)
                                                مخفی کردن
                                            @else
                                                ظاهر کردن
                                            @endif
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">آزمونی وجود ندارد ...</td>
                            </tr>
                        @endforelse
                    </table>
                </app-main-box>
{{-- todo --}}
                {{--                {{ $room->quizzes->links() }}--}}
            </div>
        </div>
    </div>
@endsection
