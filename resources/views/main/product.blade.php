@extends('layout')
@section('title','تیزویران | '/*. $product->name ??*/ )

@section('content')
    <div class="p-1 my-5"></div>
    <div class="p-1 my-5"></div>
    <div class="container mt-5">
        <div class="row justify-content-center ">
            
        <div class="col-12 col-md-4">
            <app-product-desc></app-product-desc>
        </div>

        <div class="col-12 col-md-8">
            
            <div class="row">      
                <div class="col-12 mb-2">
                    <div class="bg-dark-gray shadow rounded py-2 px-3">
                        <span class="fas fa-angle-double-left"></span>
                        <h2 style="font-size:1.3rem;display:inline-block;">دوره ی جدید ریاضی</h2>
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <div class="bg-dark-gray shadow rounded py-2 px-3">
                        <video src="/upload/test.mp4" controls class="w-100 rounded"></video>
                        <div style="margin-bottom:100px;margin-top:50px">
                            <app-title>توضیحات دوره</app-title>
                        </div>
                        <div class="my-5">
                            <app-title>سرفصل های دوره</app-title>
                            <app-product-course-item></app-product-course-item>
                            <app-product-course-item></app-product-course-item>
                            <app-product-course-item></app-product-course-item>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>
    </div>
@endsection
