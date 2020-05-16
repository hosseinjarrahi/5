@extends('Quizviran::layout')
@section('title',$quiz->name)

@section('content')
    <div class="container-fluid mb-5" style="margin-top: 50px;">
        <div class="row justify-content-center">

            <div class="p-2 shadow rounded my-5 d-flex flex-row border border-danger col-11 text-center">
                <span class="fas fa-info-circle mr-auto"></span>
                <span class="mx-auto"> قبل از به پایان رسیدن زمان مسابقه دکمه اتمام را کلیک نمایید.</span>
            </div>

            <div class="p-2 px-4 shadow rounded my-2 bg-dark-gray col-11 col-md-4 text-center">{{ $quiz->name }}</div>

            <app-exam id="{{ $quiz->id }}" questions="{{ $questions }}"></app-exam>

        </div>
        <app-count-down min="{{ $quiz->duration }}"></app-count-down>
    </div>
@endsection
