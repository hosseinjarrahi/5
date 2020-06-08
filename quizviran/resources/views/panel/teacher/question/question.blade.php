@extends('Quizviran::layout')
@section('title','تیزویران | نمایش سوال')

@section('content')
    <div class="container-fluid" style="margin-bottom: 300px;">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="teacher"></app-panel-links-header>
            </div>
        </div>

        <app-back route="{{ url()->previous() }}"></app-back>

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
            <div class="col-12 col-lg-6">
                <a href="{{ route('quizviran.question.edit',['question' => $question->id ]) }}" class="btn-sm mx-1 btn btn-primary">
                    <span class="fas fa-edit"></span>
                    <span>ویرایش</span>
                </a>
{{--                <div class="btn-sm mx-1 btn btn-danger">--}}
{{--                    <span class="fas fa-trash"></span>--}}
{{--                    <span>حذف</span>--}}
{{--                </div>--}}
            </div>
        </div>

    </div>
@endsection
