@extends('Quizviran::layout')
@section('title','نیزویران | ویرایش سوال')

@section('content')

    <div class="container-fluid">


        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
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

        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-7 rounded p-2">
                <app-main-box :dark="true" title="ویرایش سوال" icon="edit">
                    <app-question-edit-form
                            :categories="{{ auth()->user()->categories->toJson() }}"
                            route="{{ route('quizviran.question.update',['question' => $question->id]) }}"
                            :input="{{ $question->toJson() }}"
                    ></app-question-edit-form>
                </app-main-box>
            </div>
        </div>
    </div>

@endsection
