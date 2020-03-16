@extends('layout')
@section('title','نتایج مسابقه')

@section('content')
    .
    <div class="container my-5">
        <div class="row justify-content-center">
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
                            <table class="table shadow table-striped table-hover">
                                <tr>
                                    <td>رتبه</td>
                                    <td>نام کاربر</td>
                                    <td>امتیاز</td>
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $user->name ?? $user->handle }}</td>
                                        <td>{{ $user->pivot->norm }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
.
@endsection
