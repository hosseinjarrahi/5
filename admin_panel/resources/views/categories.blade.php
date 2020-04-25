@extends('Admin::layout')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت موضوعات</div>
            </div>

            <div class="col-6">
                <div class="bg-light shadow p-2">
                    <form action="{{ url('/manager/category/'.(($edit) ? $category->id : '') ) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @if($edit)
                            @method('put')
                        @endif

                        <div class="form-group">
                            <label>موضوع</label>
                            <input name="name" value="{{ $edit ? $category->name : ''}}" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>slug</label>
                            <input name="slug" value="{{ $edit ? $category->slug : ''}}" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>مادر</label>
                            <select class="form-control" name="parent_id">
                                <option value="-1" selected>-----</option>
                                @foreach($categories as $c)
                                    <option selected="{{ $edit ? ($category->parent_id == $c->id ? 'selected' : '') :'' }}"
                                            value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>تصویر</label>
                            <input type="file" name="pic" class="form-control">
                        </div>
                        <button class="btn btn-primary">ارسال</button>
                    </form>
                </div>
            </div>

            <div class="col-6">
                <div class="bg-light shadow p-2">
                    @foreach($categories as $c)
                        <div class="d-block my-2">
                            |-- {{ $c->name }}
                            <a href="{{ url("/manager/category/{$c->id}/edit") }}" class="btn py-0 btn-small btn-primary">ویرایش</a>
                            <form class="d-inline" action="{{ url('/manager/category',['category' => $c->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn py-0 btn-small btn-danger">حذف</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection