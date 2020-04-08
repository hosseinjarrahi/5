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
        $slides = Slide::all();
        return view('Admin::slide',compact('slides'));
    }

    public function destroy(Slide $slide)
    {
        File::delete(public_path($slide->pic));
        $slide->delete();
        return back();
    }

    public function store()
    {
        $request = request();
        $pic = Upload::uploadFile(['pic' => $request->file('pic')]);
        Slide::create([
            'pic' => $pic['pic'],
            'link' => $request->link
        ]);
        return back();
    }
}