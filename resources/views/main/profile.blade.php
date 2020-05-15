@extends('layout')
@section('title','تیزویران | پروفایل کاربر')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">

            <app-profile-header :user="{{ $user }}"></app-profile-header>

            <div class="col-12 col-md-6 px-4">
                <app-content-border-box style="margin-top: 200px;margin-bottom: 100px;  " title="مشخصات">
                    <app-profile-form :user="{{ $user }}"></app-profile-form>
                </app-content-border-box>
            </div>

        </div>
    </div>
@endsection
