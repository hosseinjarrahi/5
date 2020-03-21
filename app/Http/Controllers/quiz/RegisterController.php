<?php

namespace App\Http\Controllers\quiz;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RecoverRequest;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    private $token = '39796B4F63394667334B777230544D3451622F357159697169382F6368754B7674664B6B2F7A63707845553D';

    private $sender = '10003334444';

    private $messages = [
        'loginError' => [
            'message' => 'نام کاربری و یا رمز عبور اشتباه است.',
            'type' => 'error',
        ],
        'loginSuccess' => [
            'message' => 'با موفقیت وارد شدید.',
            'type' => 'success',
        ],
        'sendCodeSuccess' => [
            'message' => 'کد تایید با موفقیت ارسال شد.',
            'type' => 'success',
        ],
        'verifyError' => [
            'message' => 'کد وارده شده اشتباه است.',
            'type' => 'error',
        ],
        'registerSuccess' => [
            'message' => 'با موفقیت ثبت نام شدید.',
            'type' => 'success',
        ],
        'recoveryError' => [
            'message' => 'کاربری با این اطلاعات وجود ندارد.',
            'type' => 'error',
        ],
        'recoverNotComplete' => [
            'message' => 'متاسفانه مشکلی در انجام عملیات به وجود آمده است.',
            'type' => 'error',
        ],
        'recoverSuccess' => [
            'message' => 'رمز عبور جدید شما تا لحظاتی دیگر ارسال می شود.',
            'type' => 'success',
        ],

    ];

    public function checkAuth()
    {
        return auth()->id();
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('handle', $request->username)->first();
        if (! $user || ! Hash::check($request->password, $user->passhash)) {
            return response($this->messages['loginError']);
        }

        auth()->login($user);

        return response($this->messages['loginSuccess']);
    }

    public function logout()
    {
        auth()->logout();

        return redirect(url('/'));
    }

    public function register(RegisterRequest $request)
    {
        $random = random_int(10000, 99999);
        $this->setSession($request, $random);
        $this->sms();

        return response($this->messages['sendCodeSuccess']);
    }

    public function verify(Request $request)
    {
        if ($request->verify != session('code')) {
            return response($this->messages['verifyError']);
        }
        $user = $this->createUser();
        if (! $user->save()) {
            return response($this->messages['verifyError']);
        }
        session()->forget('code');

        return response($this->messages['registerSuccess']);
    }

    public function sendCode(RecoverRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if (! $user) {
            return response($this->messages['recoveryError']);
        }

        return $this->modifyUser($user, $request);
    }

    private function sms()
    {
        $receptor = (string)session('data')['phone'];
        $message = "کد تایید شما : " . session('code') . " تیزویران ";
        $api = new \Kavenegar\KavenegarApi($this->token);
        $api->Send($this->sender, $receptor, $message);
    }

    private function createUser(): \App\User
    {
        $user = new User;
        $data = session('data');
        $user->handle = $data['handle'];
        $user->passhash = Hash::make($data['password']);
        $user->phone = $data['phone'];
        $user->name = $data['name'] ?? '';
        $user->created = now();
        $user->level = 0;
        $user->loggedin = now();
        $user->flags = 0;
        $user->wallposts = 0;
        $user->verified = 1;

        return $user;
    }

    private function sendSms(Request &$request, int &$pass): void
    {
        $receptor = (string)$request->phone;
        $message = "رمز جدید شما : " . $pass . " تیزویران ";
        $api = new \Kavenegar\KavenegarApi($this->token);
        $api->Send($this->sender, $receptor, $message);
    }

    private function setSession($request, $random)
    {
        session([
            'data' => $request->only('handle', 'phone', 'password', 'name'),
            'code' => $random,
        ]);
    }

    private function modifyUser($user, $request)
    {
        $pass = random_int(100000000, 999999999);
        $user->passhash = Hash::make($pass);
        if ($user->save()) {
            $this->sendSms($request, $pass);

            return response($this->messages['recoverSuccess']);
        }

        return response($this->messages['recoverNotComplete']);
    }
}
