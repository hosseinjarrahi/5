@extends('Admin::layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت رویداد ها</div>
        </div>
        <div class="col-12 my-2 bg-light shadow rounded  p-3">
            <form action="{{ url('manager/event') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <span>بدنه</span>
                    <textarea name="body" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <span>تاریخ شروع</span>
                    <date-picker name="start" type="datetime"></date-picker>
                </div>
                <div class="form-group">
                    <span>تاریخ پایان</span>
                    <date-picker name="end" type="datetime"></date-picker>
                </div>
                <div class="form-group">
                    <span>نوع</span>
                    <select name="type" class="form-control">
                        <option value="top">بالا</option>
                        <option value="main">وسط</option>
                    </select>
                </div>

                <button class="btn btn-primary">افزودن</button>
            </form>
        </div>
        <div class="col-6 col-12 p-3">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>نوع</th>
                    <th>بدنه</th>
                    <th>شروع</th>
                    <th>پایان</th>
                    <th>حذف</th>
                </tr>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->type }}</td>

                    <td><textarea name="body" class="form-control" rows="10">{{ $event->body }}</textarea></td>
                    <td>{{ $event->start }}</td>
                    <td>{{ $event->end }}</td>

                    <td class="text-white">
                        <form action="{{ url('manager/event',['event' => $event->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </table>
        </div>
    </div>
</div>
@endsection