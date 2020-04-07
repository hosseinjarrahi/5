<?php

namespace Admin\Http\Controllers;

use App\Http\Upload;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderByDesc('id')->paginate(9);
        return view('Admin::products',compact('products'));
    }

    public function create(){
        return view('Admin::productAdd');
    }

    public function store(){
        dd(request()->all());
    }
//
//    public function upload()
//    {
//        dd(request()->all());
//        $user = auth()->user();
//        $avatar = Upload::uploadFile(['pic' => $request->file]);
//        File::delete(public_path($user->profile->avatar));
//        $user->profile()->update(['avatar' => $avatar['avatar']]);
//
//        return response([
//            'message' => 'با موفقیت تغییر یافت.',
//            'avatar' => $avatar['avatar'],
//        ]);
//    }
}