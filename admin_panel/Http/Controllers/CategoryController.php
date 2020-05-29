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
        /** 
         * @get('/manager/category')
         * @name('admin.category.index')
         * @middlewares(web, auth, admin)
         */
        $categories = CategoryRepo::all();
        $edit = false;

        return view('Admin::categories', compact('categories', 'edit'));
    }

    public function store(Request $request)
    {
        /** 
         * @post('/manager/category')
         * @name('admin.category.store')
         * @middlewares(web, auth, admin)
         */
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
        /** 
         * @get('/manager/category/{category}/edit')
         * @name('admin.category.edit')
         * @middlewares(web, auth, admin)
         */
        $categories = CategoryRepo::all();
        $edit = true;

        return view('Admin::categories', compact('categories', 'category', 'edit'));
    }

    public function update(Category $category, Request $request)
    {
        /** 
         * @methods(PUT, PATCH)
         * @uri('/manager/category/{category}')
         * @name('admin.category.update')
         * @middlewares(web, auth, admin)
         */
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
        /** 
         * @delete('/manager/category/{category}')
         * @name('admin.category.destroy')
         * @middlewares(web, auth, admin)
         */
        CategoryRepo::delete($category);

        return back();
    }
}
