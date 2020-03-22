@extends('layout')
@section('title','تیزویران | کلاس ها')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 my-5">
                <div class="row justify-content-center m">
                    <div class="col-11 col-md-4">
                        <img src="{{ asset('img/mainLandingLogo.png') }}" alt="logo" class="img-fluid">
                    </div>
                </div>
            </div>

            <app-slider></app-slider>
            <app-course></app-course>
        </div>
    </div>
@endsection
