@extends('Admin::layout')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-12 col-lg-6">
                <x-card title="افزودن موضوع">
                    <form action="{{ url('/manager/category/'.(($edit) ? $category->id : '') ) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @if($edit)
                            @method('put')
                        @endif

                        <div class="form-group">
                            <label>موضوع</label>
                            <input name="name" onchange="generateSlug(this)" value="{{ $edit ? $category->name : ''}}" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>نامک</label>
                            <input id="slug" name="slug" value="{{ $edit ? $category->slug : ''}}" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>مادر</label>
                            <select class="form-control" name="parent_id">
                                <option value="-1" selected>-----</option>
                                @foreach($categories as $c)
                                    <option @if($edit && $category->parent_id == $c->id )
                                            selected
                                            @endif
                                            value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($edit && $category->pic)
                            <div class="d-block position-relative bg-dark p-3 rounded">
                                <img src="{{ $category->pic }}" class="mx-auto d-block img-fluid">
                                <button type="button" onclick="deleteImage()" class="fas fa-times btn-sm position-absolute shadow btn btn-danger rounded"
                                        style="top: 0px;bottom:0px;left: 0px;"></button>
                            </div>
                        @endif

                        <div class="form-group">
                            <label>تصویر</label>
                            <input type="file" name="pic" class="form-control">
                        </div>
                        <button class="btn btn-primary">ارسال</button>
                    </form>
                </x-card>
            </div>

            <div class="col-12 col-lg-6">
                <x-card title="موضوعات سایت">
                    @foreach($categories as $c)
                        <div class="d-block my-2">
                            <span class="fas fa-grip-lines-vertical"></span> <span>{{ $c->name }}</span>

                            <span class="float-left">
                            <a href="{{ url("/manager/category/{$c->id}/edit") }}" class="btn py-0 btn-small btn-primary">ویرایش</a>
                            <form class="d-inline" action="{{ url('/manager/category',['category' => $c->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn py-0 btn-small btn-danger">حذف</button>
                            </form>
                            </span>

                        </div>
                    @endforeach
                </x-card>
            </div>

        </div>
    </div>
    @if($edit)
        <form id="deleteImageForm" action="{{ route('admin.category.delete.image',['category' => $category->id]) }}" method="post">
            @csrf
            @method('delete')
        </form>
    @endif
@endsection

@section('script')
    <script>
        function generateSlug(item) {
            slug.value = slugify(item.value);
        }

        function deleteImage() {
            deleteImageForm.submit();
        }
    </script>
@endsection
