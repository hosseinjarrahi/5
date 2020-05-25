@extends('layout')
@section('title','مشکلی در خرید رخ داده است.')

@section('content')
    <div class="container" style="margin-top: 100px;margin-bottom: 200px;">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center">
                <span class="display-1"><span class="fas fa-exclamation-circle"></span></span>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="alert text-center alert-{{ $alertType }}">
                    {!! $message !!}
                </div>
            </div>
        </div>
    </div>
@endsection
