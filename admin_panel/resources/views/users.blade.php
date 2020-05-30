@extends('Admin::layout')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-6 col-12 p-3">
                <x-card title="کاربران">
                    <table class="table table-striped">
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
                                <td class="">{{ $user->name }}</td>
                                <td>{{ $user->type }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>

                                <td class="text-white">
                                    <form action="{{ route('admin.user.destroy',['user' => $user->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </x-card>
                <div class="row justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
