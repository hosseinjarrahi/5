<?php

namespace Quizviran\Http\Controllers;

use http\Env\Request;
use App\Models\Category;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\CategoryRepo;
use Quizviran\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['has.category'])->except(['store']);
    }

    public function store(CategoryRequest $request)
    {
        $category = CategoryRepo::create($request->name);

        return response([
            'message' => 'با موفقیت انجام شد.',
            'category' => $category,
        ]);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        CategoryRepo::update($category,$request->name);

        return response(['message' => 'با موفقیت انجام شد.']);
    }

    public function destroy(Category $category)
    {
        CategoryRepo::update($category);

        return response(['message' => 'با موفقیت انجام شد.']);
    }
}
