@extends('Admin::layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت نظرات</div>
        </div>

        <div class="col-6 col-12 p-3">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>نظر</th>
                    <th>نام و نام خانوادگی</th>
                    <th>تاریخ</th>
                    <th>نمایش</th>
                    <th>تایید</th>
                    <th>حذف</th>
                </tr>
                @foreach($comments as $comment)
                <tr>
                    <td>{{ $comment->comment }}</td>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ \Morilog\Jalali\Jalalian::forge($comment->created_at) }}</td>
                    <td>{{ $comment->show ? 'قابل نمایش' : 'مخفی' }}</td>

                    <td class="text-white">
                        <form action="{{ url('manager/comment',['comment' => $comment->id]) }}" method="post">
                            @csrf
                            @method('patch')
                            <button class="btn btn-sm btn-primary">{{ $comment->show ? 'عدم تایید' : 'تایید' }}</button>
                        </form>
                    </td>

                    <td class="text-white">
                        <form action="{{ url('manager/comment',['comment' => $comment->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </table>
            <div class="row justify-content-center">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection