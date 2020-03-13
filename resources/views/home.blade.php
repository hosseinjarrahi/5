@extends('layout')
@section('title','تیزویران | کلاس ها')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 my-5">
                <div class="row justify-content-center m">
                    <div class="col-11 col-md-4">
                        <img src="{{ asset('img/landing.png') }}" alt="logo" class="img-fluid">
                    </div>
                </div>
            </div>

            <app-quiz quizzes="{{ $quizzes }}"></app-quiz>
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
