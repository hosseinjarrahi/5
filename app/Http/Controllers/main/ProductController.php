<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class ProductController extends Controller
{
	public function addForm ()
	{
		$cats = Category::all();
		return view('admin.productAdd' , compact('cats'));
	}

	public function add (Request $request)
	{
		$request->validate(['file.*' => ['required' , 'mimes:jpeg,bmp,jpg,png']]);
		$imgPath = null;
		$filesPath = null;
		if ( $request->hasFile('img') && !is_null($request->img) ) {
			$path = random_int(0 , 99999).time().'_.'.$request->img->getClientOriginalExtension();
			$request->img->move(public_path('upload') , $path);
			$imgPath = $path;
		}
		foreach ( $request->file as $file ) {
			$path = random_int(0 , 99999).time().'_.'.$file->getClientOriginalExtension();
			$file->move(public_path('upload') , $path);
			$filesPath .= '|'.$path;
		}
		try {
			$p = new Product;
			$p->img = $imgPath;
			$p->file = $filesPath;
			$p->title = $request->title;
			$p->category_id = $request->category;
			$p->description = $request->description;
			$p->save();
			return back();
		} catch (\Exception $e) {
			$filesPath = new \Illuminate\Support\Collection($filesPath);
			foreach ( $filesPath as $file ) {
				File::delete(public_path('upload/'.ltrim($file , '|')));
			};
			$this->deleteFile($imgPath);
			return back();
		}
	}

	public function remove (Product $id)
	{
		if ( $id->delete() ) {
			$this->deleteFile($id->img);
			$files = explode('|' , ltrim($id->file,'|'));
			foreach ($files as $file)
				$this->deleteFile($file);
		};
		return back();
	}

	public function manage ()
	{
		$products = Product::paginate(12);
		return view('admin.productManage' , compact('products'));
	}

	// video
	public function addFormVideo ()
	{
		$cats = Category::all();
		return view('admin.videoAdd' , compact('cats'));
	}

	public function addVideo (Request $request)
	{
		if ( $request->hasFile('img') && !is_null($request->img) ) {
			$path = random_int(0 , 99999).time().'_.'.$request->img->getClientOriginalExtension();
			$request->img->move(public_path('upload') , $path);
			$imgPath = $path;
		}
		try {
			$p = new Video;
			$p->img = $imgPath;
			$p->price = $request->price;
			$p->file = $request->file;
			$p->demo = $request->demo;
			$p->title = $request->title;
			$p->time = $request->time;
			$p->teacher = $request->teacher;
			$p->category_id = $request->category;
			$p->description = $request->description;
			$p->save();
			return back();
		} catch (\Exception $e) {
			$this->deleteFile($imgPath);
			return back();
		}
	}

	public function removeVideo (Video $id)
	{
		if ( $id->delete() ) $this->deleteFile($id->img);
		return back();
	}

	public function manageVideo ()
	{
		$products = Video::paginate(12);
		return view('admin.videoManage' , compact('products'));
	}

	/**
	 * @param string $imgPath
	 */
	private function deleteFile ($filePath): void
	{
		$filePath = public_path('upload/'.$filePath);
		if(file_exists($filePath))
			File::delete($filePath);
	}

}
