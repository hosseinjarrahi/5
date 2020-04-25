<?php

namespace App\Http\Controllers;

use App\Payment\Idpay;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function complete(){
        return (new Idpay(5000,'ss'))->pay();
    }

    public function reply(Request $request)
    {
        dd($request->all());
    }
}
