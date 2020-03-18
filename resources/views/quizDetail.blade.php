@extends('layout')
@section('title','جزییات')

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
                        <td>نام کاربر</td>
                        <td>تلفن</td>
                        <td>نمره سوالات تستی</td>
                        <td>دانلود فایل ارسالی</td>
                    </tr>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name ?? $user->handle }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->pivot->norm }}</td>
                        <td>
                            <a class="btn btn-block btn-primary"
                               href="{{ url($user->fileInQuiz($quiz->id)->get()[0]->file ?? '' ) }}">
                                دانلود
                            </a>
                        </td>

                    </tr>
                    @endforeach
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
