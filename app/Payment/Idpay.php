<?php

namespace App\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class Idpay
{
    protected $amount;

    protected $callback;

    protected $order_id;

    protected $desc;

    protected $payment;

    public function __construct($amount, $desc)
    {
        $this->amount = $amount;
        $this->desc = $desc;
        $this->callback = url('/complete/reply');
        $this->payment = Payment::create([
           'user_id' => auth()->id(),
           'trans_id' => -1
        ]);
    }

    public function pay()
    {
        $params = [
            'order_id' => $this->payment->id,
            'amount' => $this->amount,
            'name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
            'mail' => auth()->user()->email,
            'desc' => $this->desc,
            'callback' => $this->callback,
            'reseller' => null,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'X-API-KEY' => '6a7f99eb-7c20-4412-a972-6dfb7cd253a4',
            'X-SANDBOX' => '1',
        ];

        $result = Http::withHeaders($headers)->post('https://api.idpay.ir/v1.1/payment', $params);

        if (! $result->successful()) {
            return response('nok');
        }

        $result = $result->json();
        $this->payment->trans_id = $result['id'];
        $this->payment->save();

        return redirect($result['link']);
    }
}