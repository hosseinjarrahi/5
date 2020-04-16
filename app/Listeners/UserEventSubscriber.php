<?php

namespace App\Listeners;

use App\Mail\ResetPassword;
use App\Mail\VerificationCode;
use App\Events\ResetPasswordEvent;
use App\Events\SendVerificationCode;
use App\Events\UserRegisterEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserEventSubscriber
{
    private $token = '39796B4F63394667334B777230544D3451622F357159697169382F6368754B7674664B6B2F7A63707845553D';

    private $sender = '10003334444';

    private function sendNewPasswordByEmail($email, $password)
    {
        Mail::to($email)
            ->send(new ResetPassword($password));
    }

    private function sendEmail()
    {
        $receptor = (string)session('data')['email'];
        Mail::to($receptor)
        ->send(new VerificationCode());
    }

    private function sendNewPasswordBySMS($phone, $password)
    {
        $receptor = (string)$phone;
        $message = "رمز جدید شما : " . $password . " تیزویران ";
        $api = new \Kavenegar\KavenegarApi($this->token);
        $api->Send($this->sender, $receptor, $message);
    }

    private function sendVerifySMS()
    {
        $receptor = (string)session('data')['phone'];
        $message = "کد تایید شما : " . session('code') . " تیزویران ";
        $api = new \Kavenegar\KavenegarApi($this->token);
        $api->Send($this->sender, $receptor, $message);
    }

    public function sendVerificationCode($event)
    {
        $random = random_int(10000, 99999);
        $request = $event->request;
        session([
            'data' => $request->only('type', 'phone', 'password', 'name'),
            'code' => $random,
        ]);

        if ($event->driver == 'email') {
            $data = session('data');
            $data['email'] = $data['phone'];
            unset($data['phone']);
            session(['data' => $data]);
            $this->sendEmail();
        } elseif ($event->driver == 'sms') {
            $this->sendVerifySMS();
        }
    }

    public function resetPassword($event)
    {
        if ($event->driver == 'email') {
            $this->sendNewPasswordByEmail($event->phone, $event->password);
        } elseif ($event->driver == 'sms') {
            $this->snedNewPasswordBySMS($event->phone, $event->password);
        }
    }

    public function subscribe($events)
    {
        $events->listen(SendVerificationCode::class, 'App\Listeners\UserEventSubscriber@sendVerificationCode');
        $events->listen(ResetPasswordEvent::class, 'App\Listeners\UserEventSubscriber@resetPassword');
    }
}
