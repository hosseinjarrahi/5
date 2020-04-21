<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Coupon;
use App\Models\HomeBox;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Category;
use Illuminate\Http\Request;
use Conner\Tagging\Model\Tag;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\ProductResource;
use Morilog\Jalali\Jalalian;
use App\Http\Resources\NotificationResource;

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
        $events = Event::all();
        $mainEvent = $events->where('type','main')->first() ?? new Event();
        return view('main.home', compact('slides', 'boxes','mainEvent'));
    }

    public function category(Category $category)
    {
        $products = $category->products()->orderByDesc('id')->paginate(9);

        $children = $category->children;

        (! $products->isEmpty()) ?: abort(404);

        $links = $products->links();

        $products = ProductResource::collection($products)->toJson();

        return view('main.category', compact('products', 'category', 'links','children'));
    }

    public function product($category, Product $product)
    {
        $files = $product->files;
        $tags = $product->tags;
        $sames = ProductResource::collection(Product::randomByCategory($category))->toJson();
        $meta = $product->meta;
        $release = Jalalian::forge($product->created_at)->format('Y/m/d');
        $comments = $product->comments()->where('show', true)->get();

        return view('main.product', compact('comments', 'product', 'files', 'sames', 'meta', 'tags', 'release'));
    }

    public function checkCoupon(CouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->coupon)->first();
        if (! $coupon || ! $coupon->valid($request->productId)) {
            return response(['message' => 'کد تخفیف نامعتبر است.'], 404);
        }

        return response([
            'message' => 'اعمال شد.',
            'offer' => $coupon->offer,
        ]);
    }

    public function tag($tag)
    {
        $tag = Tag::where('slug->fa', $tag)->first();
        $products = Product::with('tags')->withAnyTags([$tag])->orderByDesc('id')->paginate(9);
        $links = $products->links();
        $relatedTags = $products->pluck('tags');
        $products = ProductResource::collection($products)->toJson();
        $relatedTags = $relatedTags->flatten()->pluck('name', 'slug')->toJson();

        return view('main.tag', compact('products', 'tag', 'links', 'relatedTags'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $products = Product::without(['categories', 'user'])->where('title', 'LIKE', "%{$search}%");
        if ($request->view) {
            $products = $products->paginate(9);
            $links = $products->appends(request()->except('page'))->links();
            $products = ProductResource::collection($products)->toJson();
            return view('main.search', compact('products', 'search','links'));
        }
        $products = ProductResource::collection($products->limit(5)->get())->toJson();
        return response($products);
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->orderByDesc('id')->paginate(10);
        auth()->user()->unreadNotifications->markAsRead();
        $links = $notifications->links();
        $notifis = NotificationResource::collection($notifications)->toJson();
        return view('main.notifications',compact('notifis','links'));
    }

    private function markAsReadNotifications($notifications)
    {
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }
    }
}
