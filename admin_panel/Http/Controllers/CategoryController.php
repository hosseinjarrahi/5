<?php

namespace Admin\Http\Controllers;

use App\Http\Upload;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $edit = false;
        return view('Admin::categories',compact('categories','edit'));
    }

    public function store()
    {
        $request = request();

        $c = new Category;
        $c->name = $request->name;
        $c->pic = ($request->pic) ? Upload::uploadFile(['pic' => $request->pic])['pic'] : null;
        $c->slug = $request->slug;
        $c->parent_id = $request->parent_id == -1 ? null : $request->parent_id;
        $c->save();

        return back();
    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        $edit = true;
        return view('Admin::categories',compact('categories','category','edit'));
    }

    public function update(Category $category,Request $request)
    {
        $category->name = $request->name;
        $category->pic = ($request->pic) ? Upload::uploadFile(['pic' => $request->pic])['pic'] : $category->pic;
        $category->slug = $request->slug;
        $category->parent_id = $request->parent_id == -1 ? null : $request->parent_id;
        $category->save();

        return back();
    }

    public function destroy(Category $category)
    {
        File::delete(public_path($category->pic));
        $category->delete();

        return back();
    }
}