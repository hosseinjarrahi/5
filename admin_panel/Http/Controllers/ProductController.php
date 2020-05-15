<?php

namespace Admin\Http\Controllers;

use App\Http\Upload;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->paginate(9);

        return view('Admin::products', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('Admin::productAdd', compact('categories'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        $tags = explode('-', $request->tags);

        $meta = [
            'keywords' => $request->post('keywords', null),
            'title' => $request->post('pageTitle', null),
            'description' => $request->post('pageDescription', null),
        ];

        $picPath = Upload::uploadFile(['pic' => $request->pic]);
        $video = Upload::uploadFile(['video' => $request->video]);
        $items = $this->createCourse($request);

        $product = Product::create([
            'status' => $request->status,
            'slug' => $request->slug ?? str_replace(' ', '-', $request->title),
            'title' => $request->title,
            'percentage' => $request->percentage,
            'desc' => $request->desc ?? '',
            'price' => $request->price ?? '',
            'offer' => $request->offer,
            'meta' => $meta,
            'pic' => $picPath['pic'],
            'user_id' => auth()->id() ?? 1,
            'course_items' => $items,
            'video' => $video,
        ]);

        $this->uploadFiles($request, $product);

        $category = Category::findOrFail($request->category);

        $product->tag($tags);

        if ($category) {
            $product->categories()->attach($category);
        }

        return back();
    }

    private function uploadCourses($request)
    {
        $files = [];
        $counts = (int)$request->courseCount;
        if ($counts <= 0) {
            return $files;
        }
        foreach (range(1, $counts) as $count) {
            $file = new \App\Models\File();
            $file->name = $request->file('courseFile' . $count)->getClientOriginalName();
            $file->path = '/' . $request->file('courseFile' . $count)->storeAs('courses/' . Jalalian::forge(date('y-m-d'))->format('y-m'),
                    time() . random_int(0, 100) . '.' . $request->file('courseFile' . $count)->extension());
            $file->hash = Str::random(50);
            $file->user_id = auth()->id();
            $file->save();
            $files['courseFile' . $count] = $file;
        }

        return $files;
    }

    private function uploadFiles($request, $product)
    {
        $counts = (int)$request->fileCount;
        if ($counts <= 0) {
            return;
        }
        $files = null;
        foreach (range(1, $counts) as $count) {
            $file = new File();
            $file->file = $request->file('file' . $count)->storeAs('files/' . Jalalian::forge(date('y-m-d'))->format('y-m'),
                time() . random_int(0, 100) . '.' . $request->file('file' . $count)->extension());
            $files[] = \App\Models\File::create([
                'file' => $file->file,
                'user_id' => auth()->id() ?? 1,
            ]);
        }
        $product->files()->saveMany($files);
    }

    private function createCourse($request)
    {
        if ($request->courseCount <= 0) {
            return;
        }
        $coursePath = $this->uploadCourses($request);

        $items = [];

        foreach (range(1, $request->courseCount) as $count) {
            $items[] = [
                'title' => $request->post('courseTitle' . $count),
                'hash' => $coursePath['courseFile' . $count]->hash,
                'free' => $request->post('courseFree' . $count) == 'on' ? true : false,
            ];
        }

        return $items;
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('Admin::productEdit', compact('categories', 'product'));
    }

    public function update()
    {
        $request = request();

        return back();
    }

    public function destroy(Product $product)
    {
        File::delete(public_path($product->pic));
        $product->delete();

        return back();
    }
}
