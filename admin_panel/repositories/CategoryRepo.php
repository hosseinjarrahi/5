<?php

namespace Admin\repositories;

use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryRepo
{
    public static function all()
    {
        return Category::all();
    }

    public static function find($category)
    {
        return Category::find($category);
    }

    public static function create($request)
    {
        $category = new Category;

        return self::update($category, $request);
    }

    public static function update($category, $request)
    {
        $category->name = $request['name'];
        $category->pic = $request['pic'] ?? null;
        $category->slug = $request['slug'];
        $category->parent_id = ($request['parent_id'] == -1) ? null : $request['parent_id'];

        return $category->save();
    }

    public static function delete($category)
    {
        self::deleteImage($category->pic);

        return $category->delete();
    }

    public static function deleteImage($category)
    {
        File::delete(public_path($category->pic));
        return $category->update(['pic' => null]);
    }
}
