@extends('Quizviran::layout')
@section('title','تیزویران | مدیریت آزمون ها')

@section('content')
  <div class="container-fluid">

    <div class="row justify-content-center">
      <div class="bg-dark-gray col-12" style="padding-top: 100px;">
        <app-panel-links-header type="{{ $user->type }}"></app-panel-links-header>
      </div>
    </div>

    <app-breadcrumb>
      <app-breadcrumb-item route="{{ route('quizviran.panel') }}">
        پنل مدیریت
      </app-breadcrumb-item>
      <app-breadcrumb-item route="{{ route('quizviran.room.show',['room' => $room->link]) }}">
        {{ $room->name }}
      </app-breadcrumb-item>
      <app-breadcrumb-item :active="true">
        مدیریت آزمون ها
      </app-breadcrumb-item>
    </app-breadcrumb>

    <div class="row px-md-5 justify-content-center mt-5">
      <div class="col-12 col-lg-6 mb-5 p-3">
        <app-exam-make :room="{{ $room->id }}"></app-exam-make>
      </div>
      <div class="col-12">
        <app-main-box :dark="true" title="آزمون های شما" icon="align-right">
          <app-exam-list
              :exams="{{ $room->exams->toJson() }}"
          ></app-exam-list>
        </app-main-box>
      </div>
    </div>

  </div>
@endsection
