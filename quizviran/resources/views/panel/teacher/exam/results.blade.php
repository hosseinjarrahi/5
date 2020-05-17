@extends('Quizviran::layout')
@section('title','تیزویران | نتایج آزمون')

@section('content')

    <div class="container">
        <div class="row justify-content-center" style="margin-top: 100px;">
            <div class="col-md-6 col-12">
                <img src="{{ asset('img/results.png') }}"
                     alt="results_norm"
                     class="img-fluid d-block mx-auto"
                >
            </div>
            <div class="col-md-6 col-12">

                <table class="table shadow table-striped table-hover">
                    <tr>
                        <td>آزمون</td>
                        <td>تعداد شرکت کنندگان</td>
                        <td>امتیاز آزمون</td>
                    </tr>
                    <tr>
                        <td>{{ $quiz->name }}</td>
                        <td>{{ $quiz->users()->count() }}</td>
                        <td>{{ $quiz->questions->sum('norm') }}</td>
                    </tr>
                </table>


                <div class="container-fluid my-5">
                    <div class="row justify-content-center">
                        <div class="col-12 col-5">
{{--                            <a href="pdf" class="btn btn-primary btn-block py-0 mb-2 shadow">دریافت نتایج به صورت pdf</a>--}}
                            <app-result-list :users="{{ $users->toJson() }}" :questions="{{ $quiz->questions }}"></app-result-list>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    .
@endsection
