@extends('layout')
@section('title','تیزویران | '/*. $product->name ??*/ )

@section('content')
    <div class="p-1 my-5"></div>
    <div class="p-1 my-5"></div>
    <div class="container mt-5">
        <div class="row justify-content-center  align-items-center align-items-md-start">
            
        <div class="col-12 col-md-4 mb-5">
            <app-product-desc></app-product-desc>
            <app-bio></app-bio>
        </div>

        <div class="col-12 col-md-8">
            
            <div class="row">

                <div class="col-12 mb-2">
                    <div class="bg-dark-gray shadow rounded py-2 px-3">
                        <span class="fas fa-angle-double-left"></span>
                        <h2 style="font-size:1.3rem;display:inline-block;">دوره ی جدید ریاضی</h2>
                    </div>
                </div>

                <div class="col-12 mb-2 overflow-hidden">
                    <div class="container-fluid bg-dark-gray shadow rounded py-2 px-3">
                        <video src="/upload/test.mp4" controls class="w-100 rounded"></video>
                        <div style="margin-bottom:50px;margin-top:50px">
                            <app-title>توضیحات</app-title>
                            <p class="p-2 w-100" style="white-space:pre-wrap;">
                                این جا جایی است که متنن را وارد میکنیم تا از دست شیزان رجیم در امان باشیم اما چرا اباید؟
                            </p>
                        </div>
                        <div class="my-5">
                            <app-title>سرفصل ها</app-title>
                            <app-product-course-item></app-product-course-item>
                            <app-product-course-item></app-product-course-item>
                            <app-product-course-item></app-product-course-item>
                        </div>
                        <div class="my-2 rounded " style="border:1px solid #f5f5f5">
                            <div class="d-flex flex-column flex-md-row">
                                <span class="m-2 p-2 text-white">
                                    <span class="fas fa-download"></span>
                                    <a href=""> دانلود </a>
                                </span>
                                <span class="m-2 p-2 text-white">
                                    <span class="fas fa-file"></span>
                                    <span> نوع فایل: </span>
                                    <span> pdf </span>
                                </span>
                                <span class="m-2 p-2 text-white">
                                    <span class="fas fa-box"></span>
                                    <span> حجم: </span>
                                    <span> 2Mb </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 my-4">
                    <div class="rounded">
                        <app-content-border-box title="دوره های پیشنهادی">
                            <div class=" row justify-content-center align-items-center">
                                <app-course-card></app-course-card>
                                <app-course-card></app-course-card>
                                <app-course-card></app-course-card>
                            </div>
                        </app-content-border-box>
                    </div>
                </div>

                <div class="col-12 my-4">
                    <app-content-border-box title="نظرات">
                        <div class="container">
                            <div class="mt-3 row justify-content-center align-items-center">
                                <app-comments></app-comments>
                            </div>
                        </div>
                    </app-content-border-box>
                    <app-comment-dialog class="mt-5"></app-comment-dialog>
                    <span class="btn bg-dark-gray my-2">افزودن نظر</span>

                </div>

            </div>

        </div>

        </div>
    </div>
@endsection
