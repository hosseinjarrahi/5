@extends('layout')
@section('title','تیزویران | پروفایل کاربر')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">

            <app-profile-header :user="{{ $user }}"></app-profile-header>

            <div class="col-12 col-md-6 px-4">
                <app-content-border-box style="margin-top: 200px;margin-bottom: 100px;  " title="مشخصات">
                    <div class="w-100">
                        <div class="form-group">
                            <span class="fas fa-user"></span>
                            <span>نام و نام خانوادگی :</span>
                            <input class="form-control">
                        </div>
                        <div class="form-group">
                            <span class="fas fa-calendar"></span>
                            <span>تاریخ تولد :</span>
                            <input class="form-control">
                        </div>
                        <div class="form-group">
                            <span class="fas fa-question"></span>
                            <span>نوع کاربر :</span>
                            <input disa bled value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <span class="fas fa-pen"></span>
                            <span>درباره من :</span>
                            <textarea rows="6" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <span class="fas fa-eye"></span>
                            <span>تغییر رمز :</span>
                            <input rows="6" class="form-control">
                        </div>
                        <button class="btn btn-primary">ویرایش اطلاعات</button>
                    </div>
                </app-content-border-box>
            </div>

        </div>
    </div>
@endsection
