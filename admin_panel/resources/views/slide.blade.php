@extends('Admin::layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت اسلایدر</div>
        </div>
        <div class="col-12 my-2 bg-light shadow rounded  p-3">
            <form action="{{ url('manager/slide') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <span>لینک</span>
                    <input name="link" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <span>عکس</span>
                    <input name="pic" type="file" class="form-control">
                </div>
                <button class="btn btn-primary">افزودن</button>
            </form>
        </div>
        <div class="col-6 col-12 p-3">
            <table class="table table-responsive table-bordered table-hover table-striped">
                <tr>
                    <th>لینک</th>
                    <th>تصویر</th>
                    <th>حذف</th>
                </tr>
                @foreach($slides as $slide)
                <tr>
                    <td>{{ $slide->link }}</td>
                    <td class="text-white"><img src="{{ asset($slide->pic) }}" class="col-12 col-md-5 img-fluid"></td>
                    <td class="text-white">
                        <form action="{{ url('manager/slide',['slide' => $slide->id]) }}" method="post">
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