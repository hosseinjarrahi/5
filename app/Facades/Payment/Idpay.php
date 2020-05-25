<?php

namespace App\Facades\Payment;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class Idpay
{
    protected $amount;

    protected $callback;

    protected $payment;

    public function __construct()
    {
        $this->callback = route('payment.reply');
        $this->payment = Payment::create([
            'user_id' => auth()->id(),
            'trans_id' => 0,
        ]);
    }

    public function pay($amount, $desc)
    {
        $params = [
            'order_id' => $this->payment->id,
            'amount' => $amount,
            'name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
            'mail' => auth()->user()->email,
            'desc' => $desc,
            'callback' => $this->callback,
            'reseller' => null,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'X-API-KEY' => 'ea9764a3-3ab7-4ab0-a469-0884489d2f28',
            'X-SANDBOX' => '1',
        ];

        $result = Http::withHeaders($headers)->post('https://api.idpay.ir/v1.1/payment', $params);

        if (! $result->successful()) {
            $this->payment->trans_id = $result['id'];
            $this->payment->payload = $params;
            $this->payment->state = 'error';
            $this->payment->save();
            $message = 'مشکلی در خرید رخ داده است.';
            $alertType = 'danger';

            return view('errors.message', compact('message', 'alertType'));
        }

        $result = $result->json();
        $this->payment->trans_id = $result['id'];
        $this->payment->payload = $params;
        $this->payment->save();

        return redirect($result['link']);
    }

    public function reply($request)
    {
        if ($request['status'] != 100) {
            $message = 'مشکلی در خرید رخ داده است.';
            $message .= '<br>';
            $message .= 'در صورت کسر وجه از حساب شما طی 24 ساعت به حسابتان بازگشت داده خواهد شد.';
            $message .= '<br>';
            $message .= 'شماره پیگیری بانک : ';
            $message .= $request->track_id;
            $alertType = 'danger';

            return view('errors.message', compact('message', 'alertType'));
        }

        $payment = Payment::find($request->order_id);

        if (! $this->checkIsValidPay($payment, $request)) {
            $message = 'مشکلی در خرید رخ داده است.';
            $alertType = 'danger';

            return view('errors.message', compact('message', 'alertType'));
        }

        $payload = $payment->payload;
        $payload[] = $request->all();
        $payment->payload = $payload;
        $payment->save();

        $message = 'پرداخت با موفقیت انجام شد   .';
        $message .= '<br>';
        $message .= 'در صورت کسر وجه از حساب شما طی 24 ساعت به حسابتان بازگشت داده خواهد شد.';
        $message .= '<br>';
        $message .= 'شماره پیگیری بانک : ';
        $message .= $request->track_id;
        $alertType = 'danger';

        return view('errors.message', compact('message', 'alertType'));
    }

    private function checkIsValidPay($payment, $request)
    {
        if ($payment->amount == $request->amount) {
            return true;
        }

        return false;
    }
}
