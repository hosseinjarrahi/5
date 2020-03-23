@extends('layout')
@section('title','تیزویران | ' ./* $category->name ??*/ 'دسته بندی')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-12 my-5">
                <div class="row justify-content-center m">
                    <div class="col-11 col-md-4">
                        <img src="{{ asset('img/store.png') }}" alt="logo" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <app-categories></app-categories>

        <div class="row justify-content-center p-2 p-md-0">
                <app-course-card offer="5.000"></app-course-card>
                <app-course-card></app-course-card>
                <app-course-card></app-course-card>
                <app-course-card></app-course-card>
                <app-course-card></app-course-card>
                <app-course-card></app-course-card>
                <app-course-card></app-course-card>
        </div>

    </div>
@endsection
