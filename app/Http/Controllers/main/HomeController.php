<?php

namespace App\Http\Controllers\main;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Slide;

class HomeController extends Controller
{
	public function __construct()
	{
		//        $this->middleware('auth');
	}

	public function home()
	{

		//        $myfile = fopen(public_path('img/banner.txt'), "r") or die("Unable to open file!");
		//        $src = fread($myfile,100000);
		//
		//		$table = Table::first();
		//		$posts = Forum::lastThreePosts();
		//		$products = Product::latest()->limit(6)->get();
		//		$videos = Video::latest()->limit(6)->get();
		//		$text = (Setting::first())->text ?? '';
		//		$news = News::latest()->limit(3)->get();
		$slides = Slide::all()->toJson();
        $lastProducts = ProductResource::collection(Product::lastThreeProductWith('فروشگاه'))->toJson();
        $lastJozavat = ProductResource::collection(Product::lastThreeProductWith('جزوات'))->toJson();
		return view('main.home',compact('slides','lastProducts','lastJozavat'));
	}

	public function category(Category $category)
	{
		$products = $category->entries(Product::class)->paginate(9);
        (!$products->isEmpty()) ?: abort(404);
		$links = $products->links();
		$products = ProductResource::collection($products)->toJson();
		return view('main.category' , compact('products' , 'category','links'));
	}

	public function product($category,Product $product)
	{
		return view('main.product' , compact('product'));
	}

















	public function news()
	{
		$news = News::paginate(12);
		return view('news', compact('news'));
	}

	public function new(News $news, $title)
	{
		$new = $news;
		return view('new', compact('new'));
	}

	public function alert(Request $request)
	{
		$alert = $request->alert ?? '';
		return view('alert', compact('alert'));
	}

	// public function showQuestion(Product $question)
	// {
	// 	$user = auth()->user();
	// 	if (!$user->canDownload() && !$user->downloaded($question->id))
	// 		return redirect(route('alert', ['alert' => 'تعداد دانلود های مجاز شما به پایان رسیده است.برای مشاهده سوالات باید اشتراک تهییه کنید.']));
	// 	if (!$user->downloaded($question->id)) (new Download(['user_id' => $user->userid, 'product_id' => $question->id, 'time' => time()]))->save();
	// 	$files = explode('|', ltrim($question->file, '|'));
	// 	return view('question', compact('question', 'files'));
	// }

	public function search(Request $request)
	{
		$search = $request->search;
		$videos = Video::where('title', 'LIKE', "%$search%")->get();
		$products = Product::where('title', 'LIKE', "%$search%")->get();
		$all = $videos->merge($products);
		$products = $all;
		return view('search', compact('products'));
	}

	public function shop()
	{
		$products = Product::paginate(6);
		$cats = Category::all();
		return view('shop', compact('cats', 'products'));
	}

	public function videoShop()
	{
		$videos = Video::paginate(6);
		$cats = Category::all();
		return view('videoShop', compact('cats', 'videos'));
	}

	public function video($product, $name = '')
	{
		$product = Video::find($product);
		$similars = Video::where('category_id', $product->category_id)->latest()->inRandomOrder()->limit(3)->get();
		return view('video', compact('product', 'similars'));
	}

	public function showVideo(Video $video)
	{
		$user = auth()->user();
		if (!$user->canDownloadVideo() && !$user->hasVideo($video->id))
			return redirect(route('alert', ['alert' => 'تعداد دانلود های مجاز شما به پایان رسیده است.برای مشاهده بیشتر باید اشتراک تهییه کنید.']));
		if (!$user->hasVideo($video->id)) (new Pay(['user_id' => $user->userid, 'video_id' => $video->id, 'time' => time()]))->save();
		return view('videoShow', compact('video'));
	}

	// public function product(Product $product, $name)
	// {
	// 	$downloadCount = Download::where('product_id', $product->id)->count();
	// 	$similars = Product::where('category_id', $product->category_id)->latest()->inRandomOrder()->limit(3)->get();
	// 	return view('product', compact('product', 'similars', 'downloadCount'));
	// }

	public function login(Request $request)
	{
		$request->validate(['username' => 'required', 'password' => 'required']);
		$user = User::where('handle', $request->username)->first();
		if ($user && Hash::check($request->password, $user->passhash)) {
			auth()->login($user);
		} else {
			$error = 'نام کاربری و یا رمز عبور اشتباه است.';
			session()->flash('login_error', $error);
		}
		return back();
	}

	public function logout()
	{
		auth()->logout();
		return back();
	}

	public function free()
	{
		return view('free');
	}
}
