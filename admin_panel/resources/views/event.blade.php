@extends('Admin::layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/dist/css/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <x-card title="افزودن رویداد">
                    <form action="{{ url('manager/event') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <span>بدنه</span>
                            <textarea name="body" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <span>تاریخ شروع</span>
                            <input name="start" type="text" class="form-control datetime">
                        </div>
                        <div class="form-group">
                            <span>تاریخ پایان</span>
                            <input name="end" type="text" class="form-control datetime">
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
                </x-card>
            </div>
            <div class="col-6 col-12">
                <x-card title="مدیریت رویداد ها">
                    <table class="table table-striped">
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

                                <td><textarea name="body" class="ltr form-control" rows="5" cols="50">{{ $event->body }}</textarea></td>
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
                </x-card>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/dist/js/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/persian-datepicker.min.js') }}"></script>
    <script>
        let options = {
            "timePicker": {
                "enabled": true,
                "step": 1,
                "hour": {
                    "enabled": true,
                    "step": null
                },
                "minute": {
                    "enabled": true,
                    "step": null
                },
                "second": {
                    "enabled": true,
                    "step": null
                }
            },

            "responsive": true
        }

        $(document).ready(function() {
            $(".datetime").pDatepicker(options);
        });

    </script>
@endsection
