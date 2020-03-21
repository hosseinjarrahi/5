<?php

namespace App\Http\Controllers;

use App\Pay;
use App\Plan;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function __construct()
    {
        //		$this->middleware('admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        return view('admin.usersManage');
    }

    public function setting()
    {
        $setting = Setting::first();
        return view('admin.setting', compact('setting'));
    }

    public function addSetting(Request $request)
    {
        $setting = Setting::first();
        if ($request->hasFile('logo'))
            $request->file('logo')->move(public_path('img'), 'logo.jpg');

        if (!empty($setting)) {
            $setting->update($request->except('logo'));
        } else {
            $setting = new Setting($request->except('logo'));
        }
        $setting->save();
        return back();
    }

    public function managePurchases()
    {
        $purchases = Pay::paginate(20);
        return view('admin.purchasesManage', compact('purchases'));
    }

    public function manageSubscribes()
    {
        $purchases = Plan::paginate(20);
        return view('admin.subscribesManage', compact('purchases'));
    }

    public function show()
    {
        $myfile = fopen(public_path('img/banner.txt'), "r") or die("Unable to open file!");
        $src = fread($myfile,100000);
        fclose($myfile);
        return view('admin.banner',compact('src'));
    }

    public function post(Request $request)
    {
        if($request->hasFile('banner'))
        {
            $myfile = fopen(public_path('img/banner.txt'), "r") or die("Unable to open file!");
            $src = fread($myfile,100000);
            $this->deleteFile($src.'.jpg');
            fclose($myfile);

            $file = $request->file('banner');
            $file->move(public_path('img'),"{$request->link}.jpg");
            $myfile = fopen(public_path('img/banner.txt'), "w+") or die("Unable to open file!");
            fwrite($myfile,$request->link);
        }
        return back();
    }

    private function deleteFile ($filePath): void
	{
		$filePath = public_path('img/'.$filePath);
		if(file_exists($filePath))
			File::delete($filePath);
	}

}
