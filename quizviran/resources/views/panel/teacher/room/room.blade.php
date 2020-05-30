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

        <div class="row justify-content-center">
            <div class="col-11">
                <div class="row justify-content-center">

                    <div class="col-12 col-lg-3">
                        <div class="rounded bg-dark-gray p-3" style="">
                            @if(auth()->user()->isTeacher())
                                <div class="rounded py-1 link-hover m-0 text-center">
                                    @if($room->lock)
                                        <span class="fas fa-lock-open"></span>
                                        <a href="{{ route('quizviran.room.lock',['room' => $room->link]) }}">
                                            باز کردن کلاس
                                        </a>
                                    @else
                                        <span class="fas fa-lock"></span>
                                        <a href="{{ route('quizviran.room.lock',['room' => $room->link]) }}">
                                            قفل کردن کلاس
                                        </a>
                                        <span style="font-size: 0.8rem" class="d-block text-muted">با قفل شدن کلاس دیگر کسی نمیتواند عضو شود</span>
                                    @endif
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded py-1 link-hover m-0 text-center">
                                    @if($room->gapLock)
                                        <span class="fas fa-lock-open"></span>
                                        <a href="{{ route('quizviran.room.gapLock',['room' => $room->link]) }}">
                                            باز کردن گفت و گو
                                        </a>
                                    @else
                                        <span class="fas fa-lock"></span>
                                        <a href="{{ route('quizviran.room.gapLock',['room' => $room->link]) }}">
                                            قفل کردن گفت و گو
                                        </a>
                                    @endif
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded py-1 link-hover m-0 text-center">
                                    <a href="{{ route('quizviran.exam.manage',['room' => $room->link]) }}">ایجاد آزمون</a>
                                </div>
                                <div class="dropdown-divider"></div>

                                <div class="rounded py-1 link-hover m-0 text-center">
                                    <a href="{{ route('quizviran.room.members',['room' => $room->link]) }}">اعضاء کلاس</a>
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

                    <div class="col-12 col-lg-7">
                        <div class="row">

                            @if(!$room->gapLock)
                                <div class="col-12 p-0 mt-5 my-lg-0">
                                    <app-panel-room-add-gap id="{{ $room->id }}" type="{{ get_class($room) }}"></app-panel-room-add-gap>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="mt-3">
                                    <app-content-border-box title="گفت و گو های عمومی" icon="comments">
                                        <div class="container">
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
                                                <b>
                                                    <span class="fas fa-arrow-left"></span>
                                                    {{ $exam->name }}
                                                </b>
                                                <div class="dropdown-divider"></div>
                                                <p class="text-justify">{{ $exam->desc }}</p>
                                                <div class="p-1 rounded figure-caption bg-dark-gray my-1">
                                                    <span class="d-block bg-gray rounded mb-2">زمان شروع</span>
                                                    <span class="d-block">{{ \Morilog\Jalali\Jalalian::forge($exam->start)->format('H:i Y/m/d') }}</span></div>
                                                <div class="p-1 rounded figure-caption bg-dark-gray my-1">
                                                    <span class="d-block bg-gray rounded mb-2">مدت زمان آزمون</span>
                                                    <span class="d-block">{{ $exam->duration }} دقیقه </span>
                                                </div>
                                                @if(auth()->user()->type=='teacher' || ((auth())->user()->type=='student') && $exam->isInTime())
                                                    <a href="{{ route('quizviran.exam.show',['exam' => $exam->id]) }}" class="btn btn-primary py-0 text-light my-1">ورود به
                                                        آزمون</a>
                                                @endif
                                            </div>
                                            <hr>
                                        @endforeach
                                        @if(auth()->user()->isTeacher())
                                            <a href="{{ route('quizviran.exam.manage',['room' => $room->link]) }}"
                                               class="d-block my-2 btn bg-dark-gray py-0 text-center">مدیریت آزمون ها</a>
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
        </div>

    </div>
@endsection
