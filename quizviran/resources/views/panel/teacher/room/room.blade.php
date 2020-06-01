@extends('Quizviran::layout')
@section('title','تیزویران | کلاس')

@section('content')
    <div class="container-fluid" style="margin-bottom: 300px;">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <app-panel-room-info :room="{{ $room->toJson() }}" createdat="{{ jalalyYMD($room->created_at) }}"></app-panel-room-info>

        <div class="row justify-content-center px-2 px-lg-0">

            <div class="col-12 p-0 p-lg-2 col-lg-2">
                <div class="rounded bg-dark-gray shadow" style="border:1px white dashed">
                    @if(auth()->user()->isTeacher())
                        <div class="p-2 link-hover m-0 ">
                            @if($room->lock)
                                <span class="fas fa-lock-open fa-fw"></span>
                                <a href="{{ route('quizviran.room.lock',['room' => $room->link]) }}">
                                    باز کردن کلاس
                                </a>
                            @else
                                <span class="fas fa-lock fa-fw"></span>
                                <a href="{{ route('quizviran.room.lock',['room' => $room->link]) }}"
                                   data-toggle="tooltip" data-placement="top" title="با قفل شدن کلاس دیگر کسی نمیتواند عضو شود">
                                    قفل کردن کلاس
                                </a>
                            @endif
                        </div>

                        <div class="divider"></div>
                        <div class=" p-2 link-hover m-0">
                            @if($room->gapLock)
                                <span class="fas fa-lock-open fa-fw"></span>
                                <a href="{{ route('quizviran.room.gapLock',['room' => $room->link]) }}">
                                    باز کردن گفت و گو
                                </a>
                            @else
                                <span class="fas fa-lock fa-fw"></span>
                                <a href="{{ route('quizviran.room.gapLock',['room' => $room->link]) }}">
                                    قفل کردن گفت و گو
                                </a>
                            @endif
                        </div>

                        <div class="divider"></div>
                        <div class=" p-2 link-hover m-0 ">
                            <a href="{{ route('quizviran.exam.manage',['room' => $room->link]) }}">
                                <span class="fas fa-plus fa-fw"></span>
                                <span>ایجاد آزمون</span>
                            </a>
                        </div>

                        <div class="divider"></div>
                        <div class=" p-2 link-hover m-0 ">
                            <a href="{{ route('quizviran.room.members',['room' => $room->link]) }}">
                                <span class="fas fa-users fa-fw"></span> <span>اعضاء کلاس</span>
                            </a>
                        </div>

                        {{--                        <div class="rounded position-relative p-2 link-hover m-0">--}}
                        {{--                            <a><span class="fas fa-plus fa-fw"></span> <span>ایجاد تکلیف</span></a>--}}
                        {{--                            <span class="badge bg-gray position-absolute"--}}
                        {{--                                  style="top: 8px;left: 0px;transform: rotate(-90deg)">به زودی--}}
                        {{--                                </span>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="rounded position-relative p-2 link-hover m-0">--}}
                        {{--                            <a><span class="fas fa-paper-plane fa-fw"></span> <span>تکالیف ارسالی</span></a>--}}
                        {{--                            <span class="badge bg-gray position-absolute"--}}
                        {{--                                  style="top: 8px;left: 0px;transform: rotate(-90deg)">به زودی--}}
                        {{--                                    </span>--}}
                        {{--                        </div>--}}

                    @else

                        <div class="rounded position-relative p-2 link-hover m-0 text-center" style="font-size:1.2rem">
                            <a><span class="fas fa-box-open fa-fw"></span> <span>تکالیف</span></a>
                            <span class="badge bg-gray position-absolute"
                                  style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                </span>
                        </div>

                        <div class="divider"></div>
                        <div class="rounded position-relative p-2 link-hover m-0 text-center" style="font-size:1.2rem">
                            <a><span class="fas fa-flag-checkered fa-fw"></span><span>لیگ</span></a>
                            <span class="badge badge-primary position-absolute"
                                  style="top: 8px;left: 0px;transform: rotate(-30deg)">به زودی
                                    </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-8 px-lg-4 ">
                <div class="row">

                    @if(!$room->gapLock)
                        <div class="col-12 p-0 mt-3 mb-4">
                            <app-panel-room-add-gap id="{{ $room->id }}" type="{{ get_class($room) }}"></app-panel-room-add-gap>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="mt-3">
                            <app-content-border-box title="گفت و گو های عمومی" icon="comments">
                                <div class="container-fluid px-0 px-lg-1">
                                    <div class="mt-3 row justify-content-center align-items-center">
                                        @if(!$room->comments->isEmpty())
                                            <app-comments class="mt-2" v-for="comment in {{ $room->comments->toJson() }}" :key="comment.id"
                                                          :comment="comment"
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

            <div class="col-12 col-lg-2 mt-5 mt-lg-0">
                <div class="p-0 p-lg-3 w-100">
                    <app-content-border-box style="word-break: break-all;" title="آزمون ها" icon="sticky-note">
                        <div class="container-fluid p-2" style="word-break: break-word">
                            @if(!$room->exams->isEmpty())
                                @foreach($room->exams as $exam)
                                    <div class="mt-3 text-center row flex-column justify-content-center align-items-center">

                                        <div class="d-flex flex-row flex-wrap rounded overflow-hidden figure-caption bg-dark-gray">
                                            <b class="p-2 col-12">{{ $exam->name }}</b>
                                            <p class="p-2 col-12 text-justify">{{ $exam->desc }}</p>
                                            <div class="divider"></div>
                                            <span class="p-2 col-6 col-lg-12">زمان شروع</span>
                                            <span class="p-2 col-6 col-lg-12">{{ \Morilog\Jalali\Jalalian::forge($exam->start)->format('H:i m/d') }}</span>
                                            <div class="divider"></div>
                                            <span class="p-2 col-6 col-lg-12">مدت زمان آزمون</span>
                                            <span class="p-2 col-6 col-lg-12">{{ $exam->duration }} دقیقه </span>
                                            @if(auth()->user()->isTeacher() || (!auth()->user()->isTeacher() && $exam->isInTime()))
                                                <a href="{{ route('quizviran.exam.show',['exam' => $exam->id]) }}"
                                                   class="btn btn-block btn-primary">
                                                    ورود به آزمون
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                @if(auth()->user()->isTeacher())
                                    <a href="{{ route('quizviran.exam.manage',['room' => $room->link]) }}"
                                       class="d-block my-2 btn rounded bg-dark-gray py-0 text-center">مدیریت آزمون ها</a>
                                @endif
                            @else
                                <div class="d-block text-center">آزمونی وجود ندارد...</div>
                                @if(auth()->user()->isTeacher())
                                    <a href="{{ route('quizviran.exam.manage',['room' => $room->link]) }}"
                                       class="d-block my-2 btn bg-dark-gray py-0 text-center"><span class="fas fa-plus mx-1"></span>ایجاد آزمون</a>
                                @endif
                            @endif
                        </div>
                    </app-content-border-box>
                </div>
            </div>

        </div>

    </div>
@endsection
