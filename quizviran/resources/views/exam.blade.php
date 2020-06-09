@extends('Quizviran::layout')
@section('title',$exam->name)

@section('content')
    <div class="container-fluid mb-5" style="margin-top: 50px;">
        <div class="row justify-content-center">

            <div class="px-2 shadow text-danger align-items-center rounded my-5 d-flex flex-row border border-danger col-11 text-center">
                <span class=" mt-1" style="font-size: 1.5rem">
                    <span class="fas fa-info-circle"></span>
                </span>
                <span class="mx-auto"> قبل از به پایان رسیدن زمان مسابقه دکمه اتمام را کلیک نمایید.</span>
            </div>

            <div class="p-2 px-4 d-flex flex-column col-11 col-md-5 text-center">
                <b>{{ $exam->name }}</b>
                <div style="padding: 1px" class="bg-dark-gray shadow rounded my-2"></div>
            </div>

            <app-exam id="{{ $exam->id }}" questions="{{ $questions }}"></app-exam>

        </div>
        <app-count-down min="{{ $exam->remainedTime }}"></app-count-down>
    </div>
@endsection
