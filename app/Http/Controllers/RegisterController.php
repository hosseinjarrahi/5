<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private $token = '39796B4F63394667334B777230544D3451622F357159697169382F6368754B7674664B6B2F7A63707845553D';
    private $sender = '10003334444';

    public function showVerify (Request $request)
    {
        $res = $request->validate([
            'handle' => 'required|string|unique:qa_users|min:4' ,
            'phone' => 'required|string|unique:qa_users|min:10' ,
            'name' => 'required|string' ,
            'password' => 'required|string|max:36|min:8' ,
            'confirm' => 'required|string|max:36|min:8|same:password'
        ]);
        $random = random_int(10000 , 99999);
        // send to phone number and then
        session(['data' => $request->only('handle','phone','password','name') , 'code' => $random]);
        $this->sms();
    }

    public function verify (Request $request)
    {
        if($request->verify != session('code'))
            return response(['message' => 'کد وارده شده اشتباه است.']);
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
        if(!$user->save())
            return response(['alert' => 'مشکلی در ثبت نام به وجود آمده لطفا دوباره امتحان کنید.']);
        session()->forget('code');
        return response(['alert' => 'با موفقیت ثبت نام شدید.']);
    }

    public function checkRecovery (Request $request)
    {
        $request->validate([
            'username' => 'required|string' ,
            'phone' => 'required|string|min:10' ,
        ]);
        $user = User::where('phone',$request->phone)->where('handle',$request->username)->first();
        if(!$user)
            return response( ['alert' => 'کاربری با این اطلاعات وجود ندارد.']);
        $pass = random_int(100000000 , 999999999);
        $user->passhash = Hash::make($pass);
        if($user->save())
        {
            $receptor = (string) $request->phone;
            $message = "رمز جدید شما : ".$pass." تیزویران ";
            $api = new \Kavenegar\KavenegarApi($this->token);
            $api->Send($this->sender , $receptor , $message);
            return response(['alert' => 'رمز عبور جدید شما تا لحظاتی دیگر ارسال می شود.']);
        }
        return response(['alert' => 'متاسفانه مشکلی در انجام عملیات به وجود آمده است.']);

    }

    private function sms ()
    {
        $receptor = (string) session('data')['phone'];
        $message = "کد تایید شما : ".session('code')." تیزویران ";
        $api = new \Kavenegar\KavenegarApi($this->token);
        $api->Send($this->sender , $receptor , $message);
    }
}
