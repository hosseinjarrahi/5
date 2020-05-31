<?php

namespace App\Repositories;

class CategoryRepo
{
    public static function latestProducts($category,$paginate = 9)
    {
        return $category->products()->orderByDesc('id')->paginate(9);
    }
}
