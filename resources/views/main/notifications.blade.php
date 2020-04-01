@extends('layout')
@section('title','تیزویران | اعلانات')

@section('content')

    <div class="container-fluid"  style="margin-top: 80px;">

        <div class="row justify-content-center">
            <div class="col-11 col-md-4">
                <img src="{{ asset('img/notifications.png') }}" alt="اعلانات" class="img-fluid">
            </div>
        </div>

        <div class="row justify-content-center ">
            <div class="col-12 col-md-6 header-home w-100 px-3">

                <app-notification-box></app-notification-box>
                <app-notification-box style="margin-top:40px"></app-notification-box>
                <app-notification-box style="margin-top:40px"></app-notification-box>
                <app-notification-box style="margin-top:40px"></app-notification-box>

            </div>
        </div>

    </div>
@endsection
