@extends('Quizviran::layout')
@section('title','تیزویران | ایجاد شد')

@section('content')
    <div class="container-fluid" style="margin-bottom: 100px;">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 120px;">
                <app-panel-links-header type="{{ $user->type }}"></app-panel-links-header>
            </div>
        </div>

        <div class="row px-2 px-md-5 mt-5 justify-content-center align-items-center">
            <div class="col-md-6 rounded bg-dark-gray p-3 col-12 my-2 position-relative">
                <img src="/quiz-assets/img/success.svg" alt="success" class="col-11 mx-auto d-block col-md-4 pb-5 img-fluid">
                <p class="text-justify">
                    <span>کلاس مورد نظر با موفقیت ایجاد شد.جهت عضویت دانش آموزان در کلاس کد</span> <span class="badge bg-gray">{{ $room->code }}</span> را
                    <span>به دانش آموزانتان تحویل دهید و از آن ها بخواهید پس از عضویت در سایت از بخش عضویت در کلاس کد داده شده را وارد نمایند.</span>
                </p>
                <a class="btn btn-block btn-primary py-0" href="{{ $room->url }}">ورود به کلاس</a>
            </div>
        </div>

    </div>
@endsection
