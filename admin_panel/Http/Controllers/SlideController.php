<?php

namespace Admin\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Admin\repositories\SlideRepo;
use Illuminate\Routing\Controller;

class SlideController extends Controller
{
    private $slidePath;

    public function __construct()
    {
        $this->slidePath = 'slides/' . Jalalian::now()->format('Y-m');
    }

    public function index()
    {
        /**
         * @get('/manager/setting')
         * @name('admin.setting.index')
         * @middlewares(web, auth, admin)
         */
        $slides = SlideRepo::all();

        return view('Admin::slide', compact('slides'));
    }

    public function destroy(Slide $slide)
    {
        /**
         * @delete('/manager/setting/{setting}')
         * @name('admin.setting.destroy')
         * @middlewares(web, auth, admin)
         */
        SlideRepo::delete($slide);

        return back();
    }

    public function store(Request $request)
    {
        /**
         * @post('/manager/setting')
         * @name('admin.setting.store')
         * @middlewares(web, auth, admin)
         */
        $pic = '/storage/' . $request->file('pic')->store($this->slidePath, 'public');

        SlideRepo::create($pic, $request->link);

        return back();
    }
}
