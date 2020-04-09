@extends('Admin::layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت کاربران</div>
        </div>

        <div class="col-6 col-12 p-3">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>نوع کاربر</th>
                    <th>تاریخ عضویت</th>
                    <th>تلفن</th>
                    <th>ایمیل</th>
                    <th>حذف</th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->type }}</td>
                    <td>{{ \Morilog\Jalali\Jalalian::forge($user->created_at) }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>

                    <td class="text-white">
                        <form action="{{ url('manager/user',['user' => $user->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </table>
            <div class="row justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection