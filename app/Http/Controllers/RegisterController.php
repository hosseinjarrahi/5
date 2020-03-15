<?php

namespace App\Http\Controllers;

use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    private $token = '39796B4F63394667334B777230544D3451622F357159697169382F6368754B7674664B6B2F7A63707845553D';

    private $sender = '10003334444';

    public function checkAuth()
    {
        return auth()->id();
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('handle', $request->username)->first();
        if ($user && Hash::check($request->password, $user->passhash)) {
            auth()->login($user);

            return response(['message' => 'با موفقیت وارد شدید.', 'type' => 'success']);
        }

        return response(['message' => 'نام کاربری و یا رمز عبور اشتباه است.', 'type' => 'error']);
    }

    public function logout()
    {
        auth()->logout();

        return redirect(url('/'));
    }

    public function register(RegisterRequest $request)
    {
        $random = random_int(10000, 99999);
        // send to phone number and then
        session([
            'data' => $request->only('handle', 'phone', 'password', 'name'),
            'code' => $random,
        ]);
        $this->sms();
        return response(['message'=>'کد تایید با موفقیت ارسال شد.','type'=>'success']);
    }

    public function verify(Request $request)
    {
        if ($request->verify != session('code')) {
            return response(['message' => 'کد وارده شده اشتباه است.','type' => 'error']);
        }
        $user = $this->createUser();
        if (! $user->save()) {
            return response(['message' => 'مشکلی در ثبت نام به وجود آمده لطفا دوباره امتحان کنید.','type' => 'error']);
        }
        session()->forget('code');

        return response(['message' => 'با موفقیت ثبت نام شدید.','type' => 'success']);
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10',
        ]);
        $user = User::where('phone', $request->phone)->first();
        if (! $user) {
            return response(['alert' => 'کاربری با این اطلاعات وجود ندارد.']);
        }
        $pass = random_int(100000000, 999999999);
        $user->passhash = Hash::make($pass);
        if ($user->save()) {
            $this->sendSms($request, $pass);

            return response(['alert' => 'رمز عبور جدید شما تا لحظاتی دیگر ارسال می شود.']);
        }

        return response(['alert' => 'متاسفانه مشکلی در انجام عملیات به وجود آمده است.']);
    }

    private function sms()
    {
        $receptor = (string)session('data')['phone'];
        $message = "کد تایید شما : " . session('code') . " تیزویران ";
        Log::info($message);
//        $api = new \Kavenegar\KavenegarApi($this->token);
//        $api->Send($this->sender, $receptor, $message);
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
}
