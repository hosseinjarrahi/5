@extends('layout')

@section('content')
    <div class="container-fluid mb-5">
        <div class="row justify-content-center">

        <div class="p-2 px-4 shadow rounded my-5  my-1 bg-red text-white col-11 text-center" >
            <p>
            سوالات تشریحی را با شماره سوال در برگ جواب داده و در انتها به صورت یک فایل فشرده ارسال نمایید.
            </p>
            <p>
            قبل از به پایان رسیدن زمان مسابقه دکمه اتمام را کلیک نمایید.
            </p>
        </div>
       

        

        <div class="p-2 px-4 shadow rounded my-2 bg-dark-gray  col-11 col-md-4 text-center" >{{ $quiz->name }}</div>

    <app-exam id="{{ $quiz->id }}" questions="{{ $questions }}"></app-exam>
       
    </div>
        <app-count-down min="{{ $quiz->duration }}"></app-count-down>
    </div>
@endsection
