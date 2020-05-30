<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Payment\PayFacade;

class PaymentController extends Controller
{
    public function complete(){
        /**
         * @get('/complete')
         * @name('payment.pay')
         * @middlewares(web)
         */
        return PayFacade::pay(10000,'5425');
    }

    public function reply(Request $request)
    {
        /**
         * @post('/complete/reply')
         * @name('payment.reply')
         * @middlewares(web)
         */
        return PayFacade::reply($request);
    }
}
