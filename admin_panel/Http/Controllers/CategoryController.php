<?php

namespace Admin\Http\Controllers;

use App\Models\Category;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('Admin::categories',compact('categories'));
    }
}