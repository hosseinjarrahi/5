<?php

namespace Admin\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Admin\repositories\CategoryRepo;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryRepo::all();
        $edit = false;

        return view('Admin::categories', compact('categories', 'edit'));
    }

    public function store(Request $request)
    {
        CategoryRepo::create($request->only([
            'pic',
            'slug',
            'name',
            'parent_id',
        ]));

        return back();
    }

    public function edit(Category $category)
    {
        $categories = CategoryRepo::all();
        $edit = true;

        return view('Admin::categories', compact('categories', 'category', 'edit'));
    }

    public function update(Category $category, Request $request)
    {
        CategoryRepo::update($category,$request->only([
            'pic',
            'slug',
            'name',
            'parent_id',
        ]));

        return back();
    }

    public function destroy(Category $category)
    {
        CategoryRepo::delete($category);

        return back();
    }
}
