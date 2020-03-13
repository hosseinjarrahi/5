@extends('layout')
@section('title','نتایج مسابقه')

@section('content')
    <div class="container-fluid mb-5">
        <div class="row justify-content-center">
            <div class="col-11 col-5">
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
@endsection
