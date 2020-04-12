@extends('Quizviran::layout')
@section('title','تیزویران | کلاس ها')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-12 mt-5 mb-2">
                <div class="row justify-content-center">
                    <div class="col-11 col-md-4 d-flex justify-content-center">
                        <img src="{{ asset('img/quizviran.png') }}" alt="لوگو-کوییزویران" class="img-fluid" style="margin-top: 38px">
                    </div>
                </div>
            </div>

            <div class="col-12 my-2">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-4 d-flex flex-row justify-content-center px-3">
                        <a href="#" class="mx-1">
                            <img src="{{ asset('quiz/assets/img/join-class.png') }}"
                                 class="p-1 quiz-button img-fluid" alt="join-class">
                        </a>
                        <a href="#" class="mx-1">
                            <img src="{{ asset('quiz/assets/img/dashboard.png') }}"
                                 class="p-1 quiz-button img-fluid" alt="dashboard">
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center align-items-center">
            <div class="col-11 my-2">
                <div class="row p-0 justify-content-center">
                    <div class="col-12 col-md-4 d-flex flex-row justify-content-center">
                        <app-main-box title="چالش ها" icon="dice-six">
                            <app-under-hand></app-under-hand>
                        </app-main-box>
                    </div>
                    <div class="col-12 col-md-8 d-flex flex-row justify-content-center">
                        <app-main-box title="آخرین مسابقات" icon="flag-checkered">
                            <app-main-box-last-quiz></app-main-box-last-quiz>
                        </app-main-box>
                    </div>
                </div>
            </div>

            {{--            <app-quiz :quizzes="{{ $quizzes }}"></app-quiz>--}}
            {{--
                        <app-taklif>
                            <app-taklif-card
                                desc="توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات توضیحات "
                                to="link"
                                file="link"
                                day="50"
                                id="5"
                            ></app-taklif-card>
                        </app-taklif> --}}

        </div>
    </div>
@endsection
