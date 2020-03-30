<?php

namespace App\Http\Controllers;

use App\Events\ResetPasswordEvent;
use App\Events\SendVerificationCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RecoverRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepo;

class RegisterController extends Controller
{
    public function checkAuth()
    {
        return auth()->id();
    }

    public function login(LoginRequest $request)
    {
        $user = UserRepo::findUserByPhoneOrEmail($request->var);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'نام کاربری و یا رمز عبور اشتباه است.'], 400);
        }

        auth()->login($user);

        return response(['message' => 'با موفقیت وارد شدید.']);
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }

    public function register(RegisterRequest $request)
    {
        $driver = $this->checkIsPhoneOrEmail($request->phone);
        if(UserRepo::findByPhoneOrEmail($driver)){
            return response(['message' => 'کاربری با شماره تلفن و یا ایمیل وجود دارد.'],400);
        }

        event(new SendVerificationCode($request, $driver));

        return response(['message' => 'کد تایید با موفقیت ارسال شد.']);
    }

    public function verify(Request $request)
    {
        if ($request->verify != session('code')) {
            return response(['message' => 'کد وارده شده اشتباه است.'], 400);
        }
        UserRepo::createUserBySession();

        return response(['message' => 'با موفقیت ثبت نام شدید.']);
    }

    public function resetPassword(RecoverRequest $request)
    {
        $user = UserRepo::findByPhoneOrEmail($request->phone);
        if (!$user) {
            return response(['message' => 'کاربری با این اطلاعات وجود ندارد.'], 400);
        }
        $user = UserRepo::modifyUser($user);
        event(new ResetPasswordEvent(
            $request->phone,
            $user->password,
            $this->checkIsPhoneOrEmail($request->phone)
        ));

        return response(['message' => 'رمز عبور جدید شما تا لحظاتی دیگر ارسال می شود.']);
    }

    private function checkIsPhoneOrEmail($var)
    {
        $email = \Validator::make(['phone' => $var], ['phone' => 'email']);
        $phone = \Validator::make(['phone' => $var], ['phone' =>  'numeric|digits:11']);

        if (!$email->fails())
            return 'email';
        elseif (!$phone->fails())
            return 'sms';
        return null;
    }
}
