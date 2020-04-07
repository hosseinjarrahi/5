@extends('Admin::layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت محصولات</div>
            </div>
            <div class="col-6 col-12 p-3">

                <form action="/manager/product" method="post" enctype="multipart/form-data">
                    @csrf
                    <app-product-form></app-product-form>
                </form>

            </div>
        </div>
    </div>
@endsection