<?php

namespace Admin\Http\Controllers;

use App\Models\Product;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Request;
use Admin\repositories\TagRepo;
use Admin\repositories\FileRepo;
use Illuminate\Routing\Controller;
use Admin\repositories\ProductRepo;
use Admin\repositories\CategoryRepo;
use Illuminate\Support\Facades\File as FileFacade;

class ProductController extends Controller
{
    private $coursesPath;

    private $filesPath;

    private $postPath;

    public function __construct()
    {
        $this->coursesPath = 'courses/' . Jalalian::now()->format('y-m');
        $this->filesPath = 'files/' . Jalalian::now()->format('y-m');
        $this->postPath = 'public/posts/' . Jalalian::now()->format('Y-m');
    }

    public function index()
    {
        /**
         * @get('/manager/product')
         * @name('admin.product.index')
         * @middlewares(web, auth, admin)
         */
        $products = ProductRepo::latest(9);

        return view('Admin::products', compact('products'));
    }

    public function create()
    {
        /**
         * @get('/manager/product/create')
         * @name('admin.product.create')
         * @middlewares(web, auth, admin)
         */
        $categories = CategoryRepo::all();
        $tags = TagRepo::all();

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
        $items = $this->courseMaker($request);

        $product = ProductRepo::create($request->only([
            'status',
            'slug',
            'title',
            'percentage',
            'desc',
            'price',
            'offer',
        ]), $meta, $pic, $video, $items);

        $this->fileUploader($request, $product);

        $category = CategoryRepo::find($request->category);

        $product->tag($tags);

        $product->categories()->attach($category);

        return back();
    }

    public function edit(Product $product)
    {
        /**
         * @get('/manager/product/{product}/edit')
         * @name('admin.product.edit')
         * @middlewares(web, auth, admin)
         */
        $categories = CategoryRepo::all();

        return view('Admin::productEdit', compact('categories', 'product'));
    }

    public function update(Request $request)
    {
        /**
         * @methods(PUT, PATCH)
         * @uri('/manager/product/{product}')
         * @name('admin.product.update')
         * @middlewares(web, auth, admin)
         */

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
        ProductRepo::delete($product);

        return back();
    }

    private function courseUploader($courseFiles)
    {
        $files = [];

        foreach ($courseFiles as $key => $courseFile) {
            $files[$key] = FileRepo::create($courseFile, $this->coursesPath);
        }

        return $files;
    }

    private function fileUploader($request, $product)
    {
        if ($request->makeFile != 'on') {
            return null;
        }

        $files = [];

        foreach ($request->file('files') as $uploadedFile) {
            $files[] = FileRepo::create($uploadedFile, $this->filesPath);
        }

        $product->files()->saveMany($files);
    }

    private function courseMaker($request)
    {
        if ($request->makeCourse != 'on') {
            return null;
        }

        $coursePath = $this->courseUploader($request->file('courseFiles'));

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

    private function storePublicFile($file)
    {
        if ($file) {
            $path = $file->store($this->postPath,'public');
            return '/storage/' . $path;
        }

        return null;
    }
}
