<?php

namespace Quizviran\Repositories;

use App\Models\Category;

class CategoryRepo
{
    public static function create($name)
    {
        return Category::create([
            'name' => $name,
            'user_id' => auth()->id(),
        ]);
    }

    public static function update(Category $category,$name)
    {
        return $category->update([
            'name' => $name,
        ]);
    }

    public static function delete(Category $category)
    {
        return $category->delete();
    }
}
