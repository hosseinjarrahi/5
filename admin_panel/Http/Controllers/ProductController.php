<?php

namespace Admin\Http\Controllers;

use App\Models\File;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Request;
use Conner\Tagging\Model\Tag;
use Admin\repositories\FileRepo;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File as FileFacade;

class ProductController extends Controller
{
    public function index()
    {
        /**
         * @get('/manager/product')
         * @name('admin.product.index')
         * @middlewares(web, auth, admin)
         */
        $products = Product::orderByDesc('id')->paginate(9);

        return view('Admin::products', compact('products'));
    }

    public function create()
    {
        /**
         * @get('/manager/product/create')
         * @name('admin.product.create')
         * @middlewares(web, auth, admin)
         */
        $categories = Category::all();
        $tags = Tag::all();

        return view('Admin::productAdd', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        /**
         * @post('/manager/product')
         * @name('admin.product.store')
         * @middlewares(web, auth, admin)
         */
        $tags = $request->tags;

        $meta = [
            'keywords' => $request->post('keywords', null),
            'title' => $request->post('pageTitle', null),
            'description' => $request->post('pageDescription', null),
        ];

        $pic = $this->storePublicFile($request->file('pic'));
        $video = $this->storePublicFile($request->file('video'));
        $items = $this->createCourse($request);

        $product = Product::create([
            'status' => $request->status,
            'slug' => $request->slug ?? str_replace(' ', '-', $request->title),
            'title' => $request->title,
            'percentage' => $request->percentage,
            'desc' => $request->desc,
            'price' => $request->price,
            'offer' => $request->offer,
            'meta' => $meta,
            'pic' => $pic,
            'user_id' => auth()->id(),
            'course_items' => $items,
            'video' => $video,
        ]);

        $this->uploadFiles($request, $product);

        $category = Category::find($request->category);

        $product->tag($tags);

        $product->categories()->attach($category);

        return back();
    }

    private function uploadCourses($courseFiles)
    {
        $files = [];
        $path = 'courses/' . Jalalian::now()->format('y-m');

        foreach ($courseFiles as $key => $courseFile) {
            $files[$key] = FileRepo::create($courseFile, $path);
        }

        return $files;
    }

    private function uploadFiles($request, $product)
    {
        if ($request->makeFile != 'on') {
            return null;
        }

        $files = [];
        $path = 'files/' . Jalalian::now()->format('y-m');

        foreach ($request->file('files') as $uploadedFile) {
            $files[] = FileRepo::create($uploadedFile, $path);
        }

        $product->files()->saveMany($files);
    }

    private function createCourse($request)
    {
        if ($request->makeCourse != 'on') {
            return null;
        }

        $coursePath = $this->uploadCourses($request->file('courseFiles'));

        $items = [];

        foreach ($request->courseTitles as $key => $title) {
            $items[] = [
                'title' => $title,
                'hash' => $coursePath[$key] ? $coursePath[$key]->hash : null,
                'free' => $request->courseFreeBoxes[$key] == 'on' ? true : false,
            ];
        }

        return $items;
    }

    public function edit(Product $product)
    {
        /**
         * @get('/manager/product/{product}/edit')
         * @name('admin.product.edit')
         * @middlewares(web, auth, admin)
         */
        $categories = Category::all();

        return view('Admin::productEdit', compact('categories', 'product'));
    }

    public function update()
    {
        /**
         * @methods(PUT, PATCH)
         * @uri('/manager/product/{product}')
         * @name('admin.product.update')
         * @middlewares(web, auth, admin)
         */
        $request = request();

        return back();
    }

    public function destroy(Product $product)
    {
        /**
         * @delete('/manager/product/{product}')
         * @name('admin.product.destroy')
         * @middlewares(web, auth, admin)
         */
        FileFacade::delete(public_path($product->pic));
        $product->delete();

        return back();
    }

    private function storePublicFile($file)
    {
        return Str::of($file->store('public/posts/' . Jalalian::now()->format('Y-m')))
            ->after('public/')->prepend('/storage/');
    }
}
