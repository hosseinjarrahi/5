<?php

namespace Admin\repositories;

use App\Http\Upload;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryRepo
{
    public static function all()
    {
        return Category::all();
    }

    public static function create($request)
    {
        $c = new Category;
        $c->name = $request['name'];
        $c->pic = isset($request['pic']) ? Upload::uploadFile(['pic' => $request['pic']])['pic'] : null;
        $c->slug = $request['slug'];
        $c->parent_id = $request['parent_id'] == -1 ? null : $request['parent_id'];
        $c->save();
    }

    public static function update($category,$request)
    {
        $category->name = $request['name'];
        $category->pic = ($request['pic']) ? Upload::uploadFile(['pic' => $request['pic']])['pic'] : $category->pic;
        $category->slug = $request['slug'];
        $category->parent_id = ($request['parent_id'] == -1) ? null : $request['parent_id'];
        $category->save();
    }

    public static function delete($category)
    {
        File::delete(public_path($category->pic));
        $category->delete();
    }
}
