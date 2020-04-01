@extends('layout')
@section('title','تیزویران | خانه')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center ">
            <div class="col-12 header-home w-100">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-11 col-md-4">
                            <img src="{{ asset('img/landing.png') }}" alt="لوگو-تیزویران" class="img-fluid">
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

            <div class="col-12 w-100">
                <app-slider :slides="{{ $slides }}" :event="{{ $mainEvent->toJson() }}"></app-slider>
            </div>

            <div class="col-12 w-100">
            @foreach($boxes as $box)
                @php 
                    $products = App\Http\Resources\ProductResource::collection(App\Models\Product::lastThreeProductWith($box->category))->toJson();
                @endphp
                <app-course main-image="{{ $box->pic }}" more-text="{{ $box->more_text }}" more-link="/{{ $box->category->slug }}">
                    <app-course-card v-for="product in {{ $products }}" :product="product"></app-course-card>
                </app-course>  
            @endforeach
            </div>

        </div>
    </div>
@endsection
