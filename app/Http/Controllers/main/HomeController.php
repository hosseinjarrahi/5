<?php

namespace App\Http\Controllers\main;

use AliBayat\LaravelCategorizable\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\ProductResource;
use App\Models\Coupon;
use App\Models\HomeBox;
use App\Models\Product;
use App\Models\Slide;
use Morilog\Jalali\Jalalian;
use Spatie\Tags\Tag;

class HomeController extends Controller
{
	public function __construct()
	{
		//        $this->middleware('auth');
	}

	public function home()
	{
		$slides = Slide::all()->toJson();
		$boxes = HomeBox::all();
		return view('main.home', compact('slides', 'boxes'));
	}

	public function category(Category $category)
	{
		$products = $category->entries(Product::class)->orderByDesc('id')->paginate(9);
		(!$products->isEmpty()) ?: abort(404);
		$links = $products->links();
		$products = ProductResource::collection($products)->toJson();
		return view('main.category', compact('products', 'category', 'links'));
	}

	public function product($category, Product $product)
	{
		$files = $product->files;
		$tags = $product->tags;
		$sames = ProductResource::collection(Product::randomByCategory($category))->toJson();
		$meta = $product->meta;
		$release = Jalalian::forge($product->created_at)->format('Y/m/d');
		$comments = $product->comments()->where('show',true)->get();
		return view('main.product', compact('comments','product', 'files', 'sames', 'meta','tags','release'));
	}

	public function checkCoupon(CouponRequest $request)
	{
		$coupon = Coupon::where('code', $request->coupon)->first();
		if (!$coupon || !$coupon->valid($request->productId))
			return response(['message' => 'کد تخفیف نامعتبر است.'],404);
		return response(['message' => 'اعمال شد.','offer' => $coupon->offer]);
	}

	public function tag($tag){
		$tag  = Tag::where('slug->fa',$tag)->first();
		$products = Product::with('tags')->withAnyTags([$tag])->orderByDesc('id')->paginate(9);
		$links = $products->links();
		$relatedTags = $products->pluck('tags');
		$products = ProductResource::collection($products)->toJson();
		$relatedTags = $relatedTags->flatten()->pluck('name','slug')->toJson();
		return view('main.tag',compact('products','tag','links','relatedTags'));
	}

	public function search(Request $request){
		$search = $request->search;
		$products = Product::without(['categories','user'])->where('title','LIKE',"%{$search}%")->limit(5)->get();
		return response($products);
	}

    public function notifications()
    {
        return view('main.notifications');
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

//	public function search(Request $request)
//	{
//		$search = $request->search;
//		$videos = Video::where('title', 'LIKE', "%$search%")->get();
//		$products = Product::where('title', 'LIKE', "%$search%")->get();
//		$all = $videos->merge($products);
//		$products = $all;
//		return view('search', compact('products'));
//	}

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
