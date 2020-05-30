<?php

namespace Admin\repositories;

use App\Models\Product;

class ProductRepo
{
    public static function latest($paginate = 10)
    {
        return Product::orderByDesc('id')->paginate($paginate);
    }

    public static function create($request, $meta = [], $pic = null, $video = null, $courseItems = [])
    {
        return Product::create([
            'status' => $request['status'],
            'slug' => $request['slug'],
            'title' => $request['title'],
            'percentage' => $request['percentage'],
            'desc' => $request['desc'],
            'price' => $request['price'],
            'offer' => $request['offer'],
            'meta' => $meta,
            'pic' => $pic,
            'user_id' => auth()->id(),
            'course_items' => $courseItems,
            'video' => $video,
        ]);
    }

    public static function delete($product)
    {
        return $product->delete();
    }
}
