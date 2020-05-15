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
                         style="height: 250px;margin-top: 50px; margin-bottom: 120px;">
                        <div class="text-center d-flex flex-column">
                            <div class="display-1">
                                <span class="fas fa-bell-slash"></span>
                            </div>
                            <span class="blockquote mt-3">پیامی برای خواندن وجود ندارد !!</span>
                        </div>
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
