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
            <div class="col-12 col-md-6 mt-3 w-100 px-3">

                @if(!json_decode($notifis))
                    <div class="p-3 shadow rounded bg-dark-gray d-flex justify-content-center align-items-center"
                         style="height: 100px;margin-top: 100px; margin-bottom: 200px;">
                        <h3 class="text-center">
                            <span class="fas fa-bell-slash"></span>
                            <span>پیامی برای خواندن وجود ندارد</span>
                        </h3>
                    </div>
                @endif

                <app-notification-box v-for="notifis in {{ $notifis }}" :notifis="notifis"></app-notification-box>

            </div>
            <div class="col-12 d-flex flex-row justify-content-center">
                {!! $links !!}
            </div>
        </div>

    </div>
@endsection
