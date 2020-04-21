@extends('layout')
@section('title','تیزویران | '. $meta['title'] ?? $product->title)
@section('description',$meta['description'])
@section('keywords',$meta['keywords'])

@section('content')
    <div class="p-1 my-5"></div>
    <div class="p-1 my-5"></div>
    <div class="container mt-5">
        <div class="row justify-content-center  align-items-center align-items-md-start">
            <div class="col-12 col-md-4 mb-5">
            <app-product-desc :product="{{ $product->toJson() }}" release="{{ $release }}"></app-product-desc>
                <app-bio :teacher="{{ $product->user }}"></app-bio>
            </div>

            <div class="col-12 col-md-8">
                
                <div class="row">
                    
                    <div class="col-12 mb-2">
                        <div class="bg-dark-gray shadow rounded py-2 px-3">
                            <h2 style="font-size:1.3rem;display:inline-block;">
                                <span class="fas fa-angle-double-left"></span>
                                {{ $product->title }}
                            </h2>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-2 overflow-hidden">
                        <div class="container-fluid bg-dark-gray shadow rounded py-2 px-3">

                            @if($product->head)
                                {!! $product->head !!}
                            @elseif(isset($product->course_items['demo']['embed']))
                                {!! $product->course_items['demo']['embed'] !!}
                            @endif

                            <div style="margin-bottom:50px;margin-top:50px">
                                <app-title>توضیحات</app-title>
                                <p class="p-2 text-justify w-100" style="white-space:pre-wrap;">{{ $product->desc }}</p>
                            </div>
                            <div class="my-5" v-if="{{ json_encode($product->course_items) }}">
                                <app-title>سرفصل ها</app-title>
                                <app-product-course-item v-for="(item,index) in {{ json_encode($product->course_items) }}" :item="item" :index="index"></app-product-course-item>
                            </div>
                            @foreach($files as $file)
                            <div class="my-2 rounded " style="border:1px solid #f5f5f5">
                                <div class="d-flex flex-column flex-md-row">
                                    <span class="m-2 p-2 text-white">
                                        <span class="fas fa-download"></span>
                                        <a href="{{ url('file?file='.$file->file) }}"> دانلود </a>
                                    </span>
{{--                                    <span class="m-2 p-2 text-white">--}}
{{--                                    <span class="fas fa-file"></span>--}}
{{--                                    <span> نوع فایل: </span>--}}
{{--                                    <span> {{ pathinfo($file->file) }} </span>--}}
{{--                                    </span>--}}
{{--                                    <span class="m-2 p-2 text-white">--}}
{{--                                        <span class="fas fa-box"></span>--}}
{{--                                        <span> حجم: </span>--}}
{{--                                        <span> {{ filesize(asset($file->file)) }} </span>--}}
{{--                                    </span>--}}
                                </div>
                            </div>
                            @endforeach
                        </div>
                </div>
                @if(!$tags->isEmpty())
                <div class="col-12 mb-2 overflow-hidden">
                    <div class="container-fluid bg-dark-gray shadow rounded py-2 px-3">
                        <span class="fas fa-tags mx-1"></span>
                        <span class="mx-1">برچسب ها : </span>

                        <app-tag v-for="tag in {{ $tags->toJson() }}" :link="tag.slug">@{{ tag.name }}</app-tag>

                    </div>
                </div>
                @endif
                <div class="col-12 my-4">
                    <div class="rounded px-3">
                        <app-content-border-box title="پیشنهادها">
                            <div class="row justify-content-center align-items-stretch">
                                <app-course-card  v-for="product in {{ $sames }}" :product="product"></app-course-card>
                            </div>
                        </app-content-border-box>
                    </div>
                </div>
                
                <div class="col-12 my-4">
                    <div class="rounded px-3">
                        <app-content-border-box title="نظرات">
                            <div class="container">
                                <div class="mt-3 row justify-content-center align-items-center">

                                <app-comments class="mt-2" v-for="comment in {{ $comments->toJson() }}" :comment="comment"></app-comments>
                                
                                </div>
                            </div>
                        </app-content-border-box>
                    </div>
                    @if(auth()->check())
                        <app-comment-dialog id='{{ $product->id }}' type='{{ get_class($product) }}'></app-comment-dialog>
                    @else
                        <div class="alert alert-info mt-3">
                            <span class="fas fa-info"> </span>
                            <span>جهت ارسال دیدگاه خود ابتدا <ins>وارد شوید</ins></span>.</span>
                        </div>
                    @endif 
                </div>
                
            </div>
            
        </div>
        
    </div>
</div>
@endsection
    