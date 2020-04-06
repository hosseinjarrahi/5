<?php

namespace Admin\Http\Controllers;

use App\Http\Upload;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(){
        return view('Admin::products');
    }

    public function give(\Request $request)
    {
        $products = Product::paginate(9);
        $products = ProductResource::collection($products);
        return $products;
    }

    public function upload(\Request $request)
    {
        dd($request->all());
        $user = auth()->user();
        $avatar = Upload::uploadFile(['pic' => $request->file]);
        File::delete(public_path($user->profile->avatar));
        $user->profile()->update(['avatar' => $avatar['avatar']]);

        return response([
            'message' => 'با موفقیت تغییر یافت.',
            'avatar' => $avatar['avatar'],
        ]);
    }
}