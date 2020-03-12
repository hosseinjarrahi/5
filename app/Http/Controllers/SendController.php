<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeWorkRequest;
use App\Send;
use App\Work;
use Illuminate\Http\Request;

class SendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Send  $send
     * @return \Illuminate\Http\Response
     */
    public function show(Send $send)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Send  $send
     * @return \Illuminate\Http\Response
     */
    public function edit(Send $send)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Send  $send
     * @return \Illuminate\Http\Response
     */
    public function update(HomeWorkRequest $request, Send $send)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Send  $send
     * @return \Illuminate\Http\Response
     */
    public function destroy(Send $send)
    {
        //
    }
}
