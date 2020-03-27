@extends('layout')
@section('title','تیزویران | خانه')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 header-home w-100">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-11 col-md-4">
                            <img src="{{ asset('img/landing.png') }}" alt="logo" class="img-fluid">
                        </div>
                        <div class="col-11">
                            <div class="row justify-content-center">
                                <div class="col-11 col-md-4">
                                    <app-search-box></app-search-box>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="w-100 bg-dark-gray p-3 mb-5"></div> --}}


            <app-slider :slides="{{ $slides }}"></app-slider>

            <app-course main-image="/img/courses.png" more-text="مشاهده تمامی دوره ها" more-link="/فروشگاه">
                <app-course-card v-for="product in {{ $lastProducts }}" :product="product"></app-course-card>
            </app-course>

            <app-course main-image="/img/jozavat.png" more-text="مشاهده تمامی جزوات و نمونه سوالات" more-link="/جزوات">
                <app-course-card v-for="product in {{ $lastJozavat }}" :product="product"></app-course-card>
            </app-course>

        </div>
    </div>
@endsection
