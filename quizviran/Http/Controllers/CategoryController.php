<?php

namespace Quizviran\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['has.category'])->except(['store']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return response([
            'message' => 'با موفقیت انجام شد.',
            'category' => $category,
        ]);
    }

    public function update(Category $category, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return response(['message' => 'با موفقیت انجام شد.']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(['message' => 'با موفقیت انجام شد.']);
    }
}
