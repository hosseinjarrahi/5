<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	public function show ()
	{
		$cats = Category::all();
		return view('admin.categoryManage' , compact('cats'));
	}

	public function add (Request $request)
	{
		(new Category(['name' => $request->name]))->save();
		return back();
	}

	public function delete ($id)
	{
		(Category::findOrFail($id))->delete();
		return back();
	}

	public function edit ($id,Request $request)
	{
		$cat = Category::find($id);
		$cat->name = $request->name;
		$cat->save();
		return back();
	}
}
