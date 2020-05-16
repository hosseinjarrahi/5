@extends('Quizviran::layout')
@section('title','تیزویران | کلاس')

@section('content')
    <div class="container-fluid" style="margin-bottom: 300px;">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <app-panel-room-info :room="{{ $room->toJson() }}" createdat="{{ $room->created_at->format('Y/m/d') }}"></app-panel-room-info>

        <div class="row justify-content-center">
            <div class="col-11">
                <div class="row justify-content-center">

                    <div class="col-12 col-md-3">
                        <div class="rounded bg-dark-gray p-3" style="">
                            @if(auth()->user()->type == 'teacher')
                                <div class="rounded py-1 link-hover m-0 text-center">
                                    @if($room->lock)
                                        <span class="fas fa-lock-open"></span>
                                        <a href="{{ url("/quiz/panel/room/{$room->link}/lock") }}">
                                            باز کردن کلاس
                                        </a>
                                    @else
                                        <span class="fas fa-lock"></span>
                                        <a href="{{ url("/quiz/panel/room/{$room->link}/lock") }}">
                                            قفل کردن کلاس
                                        </a>
                                        <span style="font-size: 0.8rem" class="d-block text-muted">با قفل شدن کلاس دیگر کسی نمیتواند عضو شود</span>
                                    @endif
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded py-1 link-hover m-0 text-center">
                                    @if($room->gapLock)
                                        <span class="fas fa-lock-open"></span>
                                        <a href="{{ url("/quiz/panel/room/{$room->link}/gap-lock") }}">
                                            باز کردن گفت و گو
                                        </a>
                                    @else
                                        <span class="fas fa-lock"></span>
                                        <a href="{{ url("/quiz/panel/room/{$room->link}/gap-lock") }}">
                                            قفل کردن گفت و گو
                                        </a>
                                    @endif
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded py-1 link-hover m-0 text-center">
                                    <a href="{{ url("/quiz/panel/room/{$room->link}/exams") }}">ایجاد آزمون</a>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded py-1 link-hover m-0 text-center">
                                    <a href="/quiz/panel/room/{{$room->link}}/members">اعضاء کلاس</a>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded position-relative py-1 link-hover m-0 text-center">
                                    <a>ایجاد تکلیف</a>
                                    <span class="badge badge-primary position-absolute"
                                          style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                </span>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded position-relative py-1 link-hover m-0 text-center">
                                    <a>تکالیف ارسالی</a>
                                    <span class="badge badge-primary position-absolute"
                                          style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                    </span>
                                </div>

                            @else


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

                            @if(!$room->gapLock)
                                <div class="col-12 p-0 mt-5 my-md-0">
                                    <app-panel-room-add-gap id="{{ $room->id }}" type="{{ get_class($room) }}"></app-panel-room-add-gap>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="mt-3">
                                <app-content-border-box title="گفت و گو های عمومی" icon="comments">
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
                    </div>

                    <div class="col-12 col-md-2 mt-5 mt-md-0">
                        <div class="p-0 p-md-3">
                            <app-content-border-box title="آزمون ها" icon="sticky-note">
                                <div class="container" style="word-break: break-word">
                                    @if(!$room->quizzes->isEmpty())
                                        @foreach($room->quizzes as $quiz)
                                            <div class="mt-3 row flex-column justify-content-center align-items-center">
                                                <div>{{ $quiz->name }}</div>
                                                <p class="text-justify">{{ $quiz->desc }}</p>
                                                <div class="badge bg-dark-gray my-1">زمان شروع :
                                                    <span>{{ \Morilog\Jalali\Jalalian::forge($quiz->start)->format('H:i Y/m/d') }}</span></div>
                                                <div class="badge bg-dark-gray my-1">زمان آزمون :
                                                    <span>{{ $quiz->duration }}</span> دقیقه
                                                </div>
                                                @if(auth()->user()->type=='teacher' || ((auth())->user()->type=='student') && $quiz->isInTime())
                                                    <a href="{{ url('/quiz/exam',['exam' => $quiz->id]) }}" class="btn btn-primary py-0 text-light my-1">ورود به
                                                        آزمون</a>
                                                @endif
                                            </div>
                                            <hr>
                                        @endforeach
                                        @if(auth()->user()->type=='teacher')
                                            <a href="{{ url("/quiz/panel/room/{$room->link}/exams") }}"
                                               class="d-block my-2 btn bg-dark-gray py-0 text-center">مدیریت آزمون ها</a>
                                        @endif
                                    @else
                                        <div class="d-block text-center">آزمونی وجود ندارد...</div>
                                        @if(auth()->user()->type == 'teacher')
                                            <a href="{{ url("/quiz/panel/room/{$room->link}/exams") }}"
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
