<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
	public function show ($id = null)
	{
		$news = News::paginate(20);
		$edit = is_numeric($id) ? News::find($id) : null;
		return view('admin.newsManage' ,compact('news','edit'));
	}

	public function edit (News $id,Request $request)
	{
		$id->update($request->all());
		return back();
	}

	public function add (Request $request)
	{
		News::create($request->all());
		return back();
	}

	public function delete (News $id)
	{
		$id->delete();
		return back();
	}

	//

	public function upload (Request $request)
	{
		/*******************************************************
		 * Only these origins will be allowed to upload images *
		 ******************************************************/
		$accepted_origins = ["http://127.0.0.1:8000" , "http://192.168.1.1" , "http://example.com","http://tizviran.com"];

		/*********************************************
		 * Change this line to set the upload folder *
		 *********************************************/
		$imageFolder = 'upload/';

		reset($_FILES);
		$temp = current($_FILES);
		if(is_uploaded_file($temp['tmp_name'])) {
			if(isset($_SERVER['HTTP_ORIGIN'])) {
				// same-origin requests won't set an origin. If the origin is set, it must be valid.
				if(in_array($_SERVER['HTTP_ORIGIN'] , $accepted_origins)) {
					header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
				} else {
					echo ' d';
					header("HTTP/1.1 403 Origin Denied");
					return;
				}
			}

			/*
			  If your script needs to receive cookies, set images_upload_credentials : true in
			  the configuration and enable the following two headers.
			*/ // header('Access-Control-Allow-Credentials: true');
			// header('P3P: CP="There is no P3P policy."');

			// Sanitize input
			if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/" , $temp['name'])) {
				header("HTTP/1.1 400 Invalid file name.");
				return;
			}
			// Verify extension
			if(!in_array(strtolower(pathinfo($temp['name'] , PATHINFO_EXTENSION)) , ["gif" , "jpg" , "png"])) {
				header("HTTP/1.1 400 Invalid extension.");
				return;
			}

			// Accept upload if there was no origin, or if it is an accepted origin
			$filetowrite1 = $imageFolder.time().$temp['name'];
			move_uploaded_file($temp['tmp_name'] , $filetowrite1);
			$filetowrite = "/upload/{$filetowrite1}";
			// Respond to the successful upload with JSON.
			// Use a location key to specify the path to the saved image resource.
			// { location : '/your/uploaded/image/file'}
//			dd(json_encode(['location' => asset($filetowrite1)]));
			echo json_encode(['location' => $filetowrite1]);
		} else {
			// Notify editor that the upload failed
			header("HTTP/1.1 500 Server Error");
		}


	}

}
