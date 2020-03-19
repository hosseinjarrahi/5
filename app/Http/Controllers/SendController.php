<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeWorkRequest;
use App\Send;
use App\Work;
use Illuminate\Http\Request;

class SendController extends Controller
{

    public function store(HomeWorkRequest $request)
    {
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $rand = (int) random_int(1,10).time()/random_int(1,5).random_int(1,500);
            $fileName = $rand.$file->clientExtension();
            $file->move(public_path('files'),$fileName);
            $send = new Send;
            $send->work_id = $request->id();
            $send->user_id = auth()->id();
            $send->answer = $fileName;
            return response('success',200);
        }
        return response('failed',400);
    }

}
