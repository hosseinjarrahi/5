@extends('Quizviran::layout')
@section('title','تیزویران | پنل مدیریت')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="teacher"></app-panel-links-header>
            </div>
        </div>

        <div class="row px-2 px-md-5 justify-content-center"  style="margin-top: 50px;margin-bottom: 240px;">
            <div class="col-md-6 col-12 my-2 position-relative">
                <app-main-box :dark="true" title="کلاس های من" icon="chalkboard-teacher">
                    @if($rooms->isEmpty())
                        <a class="btn btn-outline-light btn-block">
                            <span class="fas fa-plus"></span>
                            <span>ایجاد کلاس</span>
                        </a>
                    @endif
                    <app-main-box-last-classes v-for="room in {{ $rooms->toJson() }}" :room="room"></app-main-box-last-classes>
                </app-main-box>
            </div>
        </div>

    </div>
@endsection
