@extends('Quizviran::layout')
@section('title','نتایج آزمون')

@section('content')

    <div class="container" style="margin-top: 100px;margin-bottom: 180px;">
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
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->users()->count() }}</td>
                        <td>{{ $exam->questions->sum('norm') }}</td>
                    </tr>
                </table>



                <div class="container-fluid my-5">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-5">
                            <table class="table shadow table-striped table-hover">
                                <tr>
                                    <td>رتبه</td>
                                    <td>نام کاربر</td>
                                    <td>امتیاز</td>
                                </tr>
                                @foreach($users as $user)
                                    <tr @if(auth()->id() == $user->id) class="bg-info" @endif>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $user->name ?? $user->handle }}</td>
                                        <td>{{ $user->pivot->norm }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="col-12 d-flex mt-5 justify-content-center">
                            <a href="{{ route('quizviran.room.show',['room' => $room->link]) }}" class="shadow btn btn-primary">بازگشت به کلاس</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
