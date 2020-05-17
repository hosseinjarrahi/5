@extends('Quizviran::layout')
@section('title','تیزویران | نمایش سوال')

@section('content')
    <div class="container-fluid" style="margin-bottom: 300px;">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="teacher"></app-panel-links-header>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="px-5 text-right bg-gray col-12 py-2">
                <a href="{{ url()->previous() }}" class="w-100 text-light">
                    <span>بازگشت</span>
                    <span class="fas fa-arrow-left"></span>
                </a>
            </div>
        </div>


        <div class="row justify-content-center my-2">
            <div class="col-12">
                <app-exam-card
                        img="{{ $question->pic }}"
                        A="{{ $question->A }}"
                        B="{{ $question->B }}"
                        C="{{ $question->C }}"
                        D="{{ $question->D }}"
                        type="{{ $question->type }}"
                        desc="{{ $question->desc }}"
                ></app-exam-card>
            </div>
        </div>

    </div>
@endsection
