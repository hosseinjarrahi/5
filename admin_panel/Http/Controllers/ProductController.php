<?php

namespace Admin\Http\Controllers;

use App\Http\Upload;
use App\Models\Product;
use Morilog\Jalali\Jalalian;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Request;
use AliBayat\LaravelCategorizable\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->paginate(9);

        return view('Admin::products', compact('products'));
    }

    public function create()
    {
        $cats = Category::with('categories')->get();

        dd($cats);
        return view('Admin::productAdd');
    }

    public function store()
    {
        $request = request();

        $meta = [
            'keywords' => $request->post('keywords', null),
            'title' => $request->post('pageTitle', null),
            'description' => $request->post('pageDescription', null),
        ];

        $picPath = Upload::uploadFile(['pic' => $request->pic]);

        $items = $this->createCourse($request);

        $product = Product::create([
            'status' => $request->status,
            'title' => $request->title,
            'percentage' => $request->percentage,
            'desc' => $request->desc ?? 'as',
            'price' => $request->price ?? 'as',
            'offer' => $request->offer,
            'meta' => $meta,
            'pic' => $picPath['pic'],
            'course_items' => $items
        ]);

        $this->uploadFiles($request,$product);


    }
//
//    public function upload()
//    {
//        dd(request()->all());
//        $user = auth()->user();
//        $avatar = Upload::uploadFile(['pic' => $request->file]);
//        File::delete(public_path($user->profile->avatar));
//        $user->profile()->update(['avatar' => $avatar['avatar']]);
//
//        return response([
//            'message' => 'با موفقیت تغییر یافت.',
//            'avatar' => $avatar['avatar'],
//        ]);
//    }

    private function uploadCourses($request)
    {
        $path = [];
        $counts = (int)$request->courseCount;
        if ($counts <= 0) {
            return $path;
        }
        foreach (range(1, $counts) as $count) {
            $path['courseFile' . $count] = '/'.$request->file('courseFile' . $count)->storeAs('courses/' . Jalalian::forge(date('y-m-d'))->format('y-m'),
                time() . random_int(0, 100) . '.' . $request->file('courseFile' . $count)->extension());
        }

        return $path;
    }

    private function uploadFiles($request,$product)
    {
        $counts = (int)$request->fileCount;
        if ($counts <= 0) {
            return ;
        }
        $files = null;
        foreach (range(1, $counts) as $count) {
            $file = new File();
            $file->file = $request->file('file' . $count)->storeAs('files/' . Jalalian::forge(date('y-m-d'))->format('y-m'),
                time() . random_int(0, 100) . '.' . $request->file('file' . $count)->extension());
            $files[] = $file;
        }
        $product->files()->saveMany($files);
    }

    private function createCourse($request)
    {
        $coursePath = $this->uploadCourses($request);

        $items = [];

        foreach (range(1, $request->courseCount) as $count) {
            if ($request->post('courseDemo' . $count) == 'on') {
                $items['demo'] = [
                    'title' => $request->post('courseTitle' . $count),
                    'file' => $coursePath['courseFile' . $count],
                    'free' => $request->post('courseFree' . $count) == 'on' ? true : false,
                ];
            } else {
                $items[] = [
                    'title' => $request->post('courseTitle' . $count),
                    'file' => $coursePath['courseFile' . $count],
                    'free' => $request->post('courseFree' . $count) == 'on' ? true : false,
                ];
            }
        }

        return $items;
    }
}