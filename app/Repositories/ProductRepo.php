<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepo
{
    public static function showableComments($product)
    {
        return $product->comments()->where('show', true)->get();
    }

    public static function withTags($tagName,$paginate = 9)
    {
        return Product::with('tagged')
            ->withAnyTag([$tagName])
            ->orderByDesc('id')
            ->paginate($paginate);
    }

    public static function searchInTitlesQuery($search)
    {
        return Product::whereHas('categories')
            ->without(['categories', 'user'])
            ->where('title', 'LIKE', "%{$search}%");
    }
}
