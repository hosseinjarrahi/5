@extends('Admin::layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-center rounded bg-dark text-white my-2 px-4 py-1">مدیریت محصولات</div>
        </div>
        <div class="col-12 ">
            <a href="/manager/product/create" class="btn btn-primary text-white">افزودن محصول</a>
        </div>
        <div class="col-6 col-12 p-3">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>عنوان</th>
                    <th>action</th>
                </tr>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td class="text-white">
                        <form action="{{ url("/manager/product/{$product->id}") }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                        <a href="{{ url("/manager/product/{$product->id}/edit") }}" class="btn btn-sm btn-primary">ویرایش</a>
                    </td>
                </tr>
                @endforeach
                <tr class="text-center">
                    <td colspan="2">
                        <div class="d-flex justify-content-center align-items-center">
                            {{ $products->links() }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection