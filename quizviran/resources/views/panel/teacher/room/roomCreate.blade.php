@extends('Quizviran::layout')
@section('title','تیزویران | پنل مدیریت')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ $user->type }}"></app-panel-links-header>
            </div>
        </div>

        <div class="row px-2 px-md-5 justify-content-center"  style="margin-top: 50px;margin-bottom: 250px;">
            <div class="col-md-6 col-12 my-2 position-relative">
                <app-main-box :dark="true" title="ایجاد کلاس" icon="chalkboard-teacher">
                    <form action="/quiz/panel/room" method="post">
                        @csrf
                        <div class="form-group">
                            <label>نام کلاس</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <button class="btn btn-primary btn-block py-0">ایجاد</button>
                    </form>
                </app-main-box>
            </div>
        </div>

    </div>
@endsection
