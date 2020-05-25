<?php

namespace App\Http\Controllers;

use App\Payment\Idpay;
use Illuminate\Http\Request;
use App\Facades\Payment\PayFacade;

class PaymentController extends Controller
{
    public function complete(){
        return PayFacade::pay(10000,'5425');
    }

    public function reply(Request $request)
    {
        return PayFacade::reply($request);
    }
}
