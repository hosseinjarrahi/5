@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت سوالات آزمون')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
            {{--   todo : divider not place--}}
            <div class="divider"></div>
        </div>
        {{--   todo: make responsive     --}}

        <div class="row flex-nowrap bg-dark-gray px-lg-3 align-items-center figure-caption text-light"
             style="height: 40px;overflow-x: auto;overflow-y: hidden;">

            <a href="{{ route('quizviran.panel') }}" class="p-2">
                <span>پنل مدیریت</span>
            </a>
            <span class="fas fa-arrow-left"></span>

            <a href="{{ route('quizviran.room.show',['room' => $room->link]) }}" class="p-2">
                <span>{{ $room->name }}</span>
            </a>
            <span class="fas fa-arrow-left"></span>

            <a href="{{ route('quizviran.exam.manage',['room' => $room->link]) }}" class="p-2">
                <span>مدیریت آزمون ها</span>
            </a>
            <span class="fas fa-arrow-left"></span>

            <span class="p-2">
                <span>مدیریت سوالات</span>
            </span>

        </div>

        <div class="row my-5 justify-content-around justify-content-center">
            <div class="col-12 px-2 px-lg-5 col-lg-6">

                <app-question-manage-tabs>
                    <template #question>
                        <app-question-add-form :categories="{{ $categories->toJson() }}" route="{{ route('quizviran.question.store') }}"></app-question-add-form>
                    </template>

                    <template #category>
                        <app-question-category-tab :categories="{{ $categories->toJson() }}" route="{{ route('quizviran.category.store') }}"></app-question-category-tab>
                    </template>
                </app-question-manage-tabs>

            </div>

            <div class="my-3 col-12 col-md-6">
                <div class="px-2 my-4 px-lg-5 col-12">
                    <app-question-exam name="{{ $exam->name }}" :questions="{{ $exam->questions->toJson() }}" id="{{ $exam->id }}"></app-question-exam>
                </div>

                <div class="px-1 my-4 px-lg-5 col-12 mt-5">
                    <app-question-all :categories="{{ $categories->toJson() }}" :questions="{{ $allQuestions->toJson() }}" id="{{ $exam->id }}"></app-question-all>
                </div>
            </div>
        </div>


    </div>


@endsection
