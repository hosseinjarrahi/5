@extends('Quizviran::layout')
@section('title','تیزویران | کلاس')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="teacher"></app-panel-links-header>
            </div>
        </div>

        <div class="row justify-content-center my-3">
            <div class="col-11 my-2 bg-dark-gray rounded">

                <div class="d-flex p-2 flex-md-row flex-column text-center">

                    <div class="p-1 bg-light mx-2 rounded d-none d-md-flex"></div>
                    <h2 class="p-0 m-0">{{ $room->name }}</h2>
                    <div class="dropdown-divider d-block d-md-none"></div>
                    <div class="d-flex ml-md-auto align-items-center flex-column flex-md-row ">
                        @if(auth()->user()->type == 'teacher')
                            <div class="mx-3"><span>کد عضویت : </span><span>{{ $room->code }}</span></div>
                        @endif
                        <div class="dropdown-divider d-block d-md-none"></div>
                        <div class="mx-3"><span>تعداد اعضاء : </span><span>{{ $room->members()->count() }}</span></div>
                        <div class="dropdown-divider d-block d-md-none"></div>
                        <div class="mx-3"><span>ساخته شده در : </span><span>{{ $room->created_at->format('Y/m/d') }}</span></div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-11">
                <div class="row justify-content-center">

                    <div class="col-12 col-md-3">
                        <div class="rounded bg-dark-gray p-3">
                            @if(auth()->user()->type == 'teacher')
                                <div class="rounded py-1 link-hover m-0 text-center" style="font-size:1.2rem">
                                    <a href="{{ url("/quiz/panel/room/{$room->link}/quizzes") }}">ایجاد آزمون</a>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded py-1 link-hover m-0 text-center" style="font-size:1.2rem">
                                    <a href="/quiz/panel/room/{{$room->link}}/members">اعضاء کلاس</a>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded position-relative py-1 link-hover m-0 text-center" style="font-size:1.2rem">
                                    <a>ایجاد تکلیف</a>
                                    <span class="badge badge-primary position-absolute"
                                          style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                </span>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded position-relative py-1 link-hover m-0 text-center" style="font-size:1.2rem">
                                    <a>تکالیف ارسالی</a>
                                    <span class="badge badge-primary position-absolute"
                                          style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                    </span>
                                </div>
                            @else
                                <div class="rounded py-1 link-hover m-0 text-center" style="font-size:1.2rem">
                                    <a href="/quiz/panel/room/{{$room->link}}/exams">آزمون ها</a>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded position-relative py-1 link-hover m-0 text-center" style="font-size:1.2rem">
                                    <a>تکالیف</a>
                                    <span class="badge badge-primary position-absolute"
                                          style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                </span>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded position-relative py-1 link-hover m-0 text-center" style="font-size:1.2rem">
                                    <a>لیگ</a>
                                    <span class="badge badge-primary position-absolute"
                                          style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-md-7">
                        <div class="row">
                            <div class="col-12 p-0 mt-5 my-md-0">
                                <app-panel-room-add-gap id="{{ $room->id }}" type="{{ get_class($room) }}"></app-panel-room-add-gap>
                            </div>
                            <div class="col-12">
                                <app-content-border-box title="گفت و گوها">
                                    <div class="container">
                                        <div class="mt-3 row justify-content-center align-items-center">
                                            @if(!$room->comments->isEmpty())
                                                <app-comments class="mt-2" v-for="comment in {{ $room->comments->toJson() }}" :comment="comment"
                                                              type="{{ auth()->user()->type }}"></app-comments>
                                            @else
                                                <div class="d-block">گفت و گویی وجود ندارد ...</div>
                                            @endif
                                        </div>
                                    </div>
                                </app-content-border-box>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-2 mt-5 mt-md-0">
                        <div class="p-0 p-md-3">
                            <app-content-border-box title="آزمون ها">
                                <div class="container">
                                    @if(!$quizzes->isEmpty())
                                        @foreach($quizzes as $quiz)
                                            <div class="mt-3 row justify-content-center align-items-center">
                                                <div>{{ $quiz->name }}</div>
                                                <div class="badge bg-dark-gray my-1">زمان شروع : <span>{{ $quiz->start }}</span></div>
                                                <div class="badge bg-dark-gray my-1">زمان آزمون : <span>{{ $quiz->time }}</span></div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    @else
                                        <div class="d-block text-center">آزمونی وجود ندارد...</div>
                                        @if(auth()->user()->type == 'teacher')
                                            <a href="{{ url("/quiz/panel/room/{$room->link}/quizzes") }}"
                                               class="d-block my-2 btn bg-dark-gray py-0 text-center"><span class="fas fa-plus mx-1"></span>ایجاد آزمون</a>
                                        @endif
                                    @endif
                                </div>
                            </app-content-border-box>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
