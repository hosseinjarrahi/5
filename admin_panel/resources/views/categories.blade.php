@extends('Admin::layout')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت موضوعات</div>
            </div>

            <div class="col-6">
                <div class="bg-light shadow p-2">
                    <form action="{{ url('/manager/category') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label>موضوع</label>
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>مادر</label>
                            <select class="form-control" name="parent">
                                <option value="-1" selected>-----</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>تصویر</label>
                            <input type="file" class="form-control">
                        </div>
                        <button class="btn btn-primary">ارسال</button>
                    </form>
                </div>
            </div>

            <div class="col-6">
                <div class="bg-light shadow p-2">
                    @foreach($categories as $c)
                        -------
                        |-{{ $c->name }}
                        <a href="{{ url("/manager/category/{$c->id}/edit") }}" class="btn py-0 btn-small btn-primary">ویرایش</a>
                        <form class="d-inline" action="{{ url('/manager/category',['category' => $c->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn py-0 btn-small btn-danger">حذف</button>
                        </form>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection