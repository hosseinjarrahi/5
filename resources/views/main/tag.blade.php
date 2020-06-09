@extends('layout')
@section('title','تیزویران | ' . $tag->name ?? 'دسته بندی')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-12 mt-5">
                <div class="row justify-content-center my-3">
                    <div
                            class="col-12 d-flex d-flex flex-row align-items-center justify-content-center text-center"
                            style="font-size:1.5rem">

                        <div class="bg-dark-gray px-2 py-1 d-flex flex-row align-items-center justify-content-center" style="border-radius:200px;">
                            <span class="fas fa-tag bg-light circle p-2" style="color:#2f3542"></span>
                            <div class="text-white p-1  d-flex flex-row align-items-center justify-content-center">
                                <span>برچسب : </span>
                                <h1 class="p-0 m-0" style="font-size:1.5rem;">{{ $tag->name }}</h1>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 bg-dark-gray p-2 rounded shadow">
                <app-tag :key="'tag'+index" v-for="(tag , index) in {{ $relatedTags }}" :link='index' class="px-3 py-1">@{{ tag }}</app-tag>
            </div>
        </div>

        <div class="row justify-content-center p-2 p-md-0">
            <app-course-card :key="'product'+index" v-for="(product,index) in {{ $products }}" :product="product"></app-course-card>
        </div>

        <div class="row justify-content-center p-2 p-md-0">
            {!! $links !!}
        </div>

    </div>
@endsection
