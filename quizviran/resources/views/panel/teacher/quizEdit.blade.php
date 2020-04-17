@extends('Quizviran::layout')
@section('title','تیزویران | ویرایش آزمون')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <div class="row px-2 px-md-5 justify-content-center mt-5" style="margin-bottom: 60px;">
            <div class="col-11 col-md-6 mb-5 shadow rounded p-3">
                <app-quiz-edit :quiz="{{ $quiz->toJson() }}"></app-quiz-edit>
            </div>
        </div>
    </div>
@endsection
