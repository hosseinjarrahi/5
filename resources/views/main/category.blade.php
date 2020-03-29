@extends('layout')
@section('title','تیزویران | ' . $category->name ?? 'دسته بندی')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-12 mt-5">
                <div class="row justify-content-center m">
                    <div class="col-11 col-md-4">
                        <img src="{{ asset($category->pic) }}" alt="logo" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <app-categories></app-categories>

            <div class="row justify-content-center p-2 p-md-0">
                    <app-course-card v-for="product in {{ $products }}" :product="product"></app-course-card>
            </div>

            <div class="row justify-content-center p-2 p-md-0">
            {!! $links !!}
            </div>
        </div>

    </div>
@endsection
