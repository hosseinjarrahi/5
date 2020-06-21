@extends('layout')
@section('title','تیزویران | خانه')

@section('content')
  <div class="container-fluid">
    <div class="row justify-content-center ">
      <div class="col-12 header-home w-100">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-11 col-lg-4">
              <img src="{{ asset('img/landing.png') }}" alt="لوگو-تیزویران" class="img-fluid">
            </div>
            <div class="col-11">
              <div class="row justify-content-center">
                <div class="col-12 col-lg-4">
                  <app-search-box></app-search-box>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-12 my-2">
            <div class="row align-items-center justify-content-center">
              <div class="col-10 my-1 col-lg-3 d-flex flex-row justify-content-center px-3">
                <a href="/quiz" class="mx-1">
                  <img src="{{ asset('img/go-to-quizviran.png') }}" class="p-1 quiz-button img-fluid" alt="dashboard">
                </a>
              </div>
              <div class="col-10 my-1 col-lg-3 d-flex flex-row justify-content-center px-3">
                <a href="{{ route('donate') }}" class="mx-1">
                  <img src="{{ asset('img/donate.jpg') }}"
                       class="p-1 quiz-button img-fluid" alt="join-room">
                </a>
              </div>
            </div>
          </div>
        
        </div>
      </div>
      {{-- <div class="w-100 bg-dark-gray p-3 mb-5"></div> --}}
      <div class="container my-5">
        <div class="col-12 w-100">
          <app-content-border-box title="سوالات شبیه ساز تیزهوشان">
            <div class="d-flex flex-column justify-content-center align-items-center">
              <p class="text-center">سوالات فوق تخصصی شبیه ساز تیزهوشان استاد محمد خانی بزرگوار</p>
              <a href="{{ asset('img/shabihsaz.pdf') }}" class="btn mx-auto btn-primary">
                <span class="fas fa-file-pdf ml-1"></span>
                <span>دانلود</span>
              </a>
            </div>
          </app-content-border-box>
        </div>
      </div>
      
      <div class="col-12 w-100">
        <app-slider :slides="{{ $slides }}" :event="{{ $mainEvent->toJson() }}"></app-slider>
      </div>
      
      <div class="col-12 w-100">
        @foreach($boxes as $box)
          @php
            $products = App\Http\Resources\ProductResource::collection(App\Models\Product::lastThreeProductWith($box->category))->toJson();
          @endphp
          <app-course main-image="{{ $box->pic }}" more-text="{{ $box->more_text }}" more-link="/{{ $box->category->slug }}">
            <app-course-card v-for="product in {{ $products }}" :key="product.slug" :product="product"></app-course-card>
          </app-course>
        @endforeach
      </div>
    
    </div>
  </div>
@endsection
