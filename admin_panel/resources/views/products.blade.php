@extends('Admin::layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-3">
                <x-card title="محصولات">
                    @foreach($products as $product)
                        <div class="my-1 p-2 d-flex flex-row justify-content-between">
                            <span>{{ $product->title }}</span>
                            <span class="text-white d-flex flex-row">
                                <form action="{{ url("/manager/product/{$product->id}") }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn mx-2 btn-sm btn-danger">حذف</button>
                                </form>
                                <a href="{{ url("/manager/product/{$product->id}/edit") }}" class="btn btn-sm btn-primary">ویرایش</a>
                            </span>
                        </div>
                        <div class="dropdown-divider"></div>
                    @endforeach
                    <div class="text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
@endsection
