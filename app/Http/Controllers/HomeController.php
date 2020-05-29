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
        /**
         * @get('//')
         * @name('home')
         * @middlewares(web)
         */
        $slides = Slide::all()->toJson();
        $boxes = HomeBox::whereHas('category')->get();
        $events = Event::all();
        $mainEvent = $events->where('type','main')->first() ?? new Event();
        return view('main.home', compact('slides', 'boxes','mainEvent'));
    }

    public function category(Category $category)
    {
        /**
         * @get('/{category}')
         * @name('')
         * @middlewares(web)
         */
        $products = $category->products()->orderByDesc('id')->paginate(9);

        $children = $category->children;

        (! $products->isEmpty()) ?: abort(404);

        $links = $products->links();

        $products = ProductResource::collection($products)->toJson();

        return view('main.category', compact('products', 'category', 'links','children'));
    }

    public function product($category, Product $product)
    {
        /**
         * @get('/{category}/{product}')
         * @name('')
         * @middlewares(web)
         */
        $files = $product->files;
        $tags = $product->tags;
        $sames = ProductResource::collection(Product::randomByCategory($category))->toJson();
        $meta = $product->getMeta();
        $release = Jalalian::forge($product->created_at)->format('Y/m/d');
        $comments = $product->comments()->where('show', true)->get();
        return view('main.product', compact('comments', 'product', 'files', 'sames', 'meta', 'tags', 'release'));
    }

    public function checkCoupon(CouponRequest $request)
    {
        /**
         * @post('/check-coupon')
         * @name('')
         * @middlewares(web)
         */
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
        /**
         * @get('/tag/{tag}')
         * @name('')
         * @middlewares(web)
         */
        $tag = Tag::where('slug', $tag)->first();
        $products = Product::with('tagged')->withAnyTag([$tag->name])->orderByDesc('id')->paginate(9);
        $links = $products->links();
        $relatedTags = $products->pluck('tags');
        $products = ProductResource::collection($products)->toJson();
        $relatedTags = $relatedTags->flatten()->pluck('name', 'slug')->toJson();

        return view('main.tag', compact('products', 'tag', 'links', 'relatedTags'));
    }

    public function search(Request $request)
    {
        /**
         * @get('/search')
         * @name('')
         * @middlewares(web)
         */
        $search = $request->search;
        $products = Product::whereHas('categories')->without(['categories', 'user'])->where('title', 'LIKE', "%{$search}%");

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
        /**
         * @get('/notifications')
         * @name('')
         * @middlewares(web, auth)
         */
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
