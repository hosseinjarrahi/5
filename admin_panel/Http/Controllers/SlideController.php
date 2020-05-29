<?php

namespace Admin\Http\Controllers;

use App\Http\Upload;
use App\Models\Slide;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class SlideController extends Controller
{
    public function index()
    {
        /** 
         * @get('/manager/setting')
         * @name('admin.setting.index')
         * @middlewares(web, auth, admin)
         */
        $slides = Slide::all();
        return view('Admin::slide',compact('slides'));
    }

    public function destroy(Slide $slide)
    {
        /** 
         * @delete('/manager/setting/{setting}')
         * @name('admin.setting.destroy')
         * @middlewares(web, auth, admin)
         */
        File::delete(public_path($slide->pic));
        $slide->delete();
        return back();
    }

    public function store()
    {
        /** 
         * @post('/manager/setting')
         * @name('admin.setting.store')
         * @middlewares(web, auth, admin)
         */
        $request = request();
        $pic = Upload::uploadFile(['pic' => $request->file('pic')]);
        Slide::create([
            'pic' => $pic['pic'],
            'link' => $request->link
        ]);
        return back();
    }
}