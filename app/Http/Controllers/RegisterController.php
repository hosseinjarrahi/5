<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Morilog\Jalali\Jalalian;
use App\Events\ResetPasswordEvent;
use App\Events\SendVerificationCode;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Quizviran\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\File;
use App\Http\Requests\RecoverRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepo;

class RegisterController extends Controller
{
    public function checkAuth()
    {
        /**
         * @post('/check-auth')
         * @name('')
         * @middlewares(web)
         */
        return response()->json(auth()->check() ? auth()->id() : false);
    }

    public function login(LoginRequest $request)
    {
        /**
         * @post('/login')
         * @name('')
         * @middlewares(web, guest)
         */
        $user = UserRepo::findByPhoneOrEmail($request->variable);
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(['message' => 'نام کاربری و یا رمز عبور اشتباه است.'], 400);
        }

        auth()->login($user);

        return response(['message' => 'با موفقیت وارد شدید.']);
    }

    public function logout()
    {
        /**
         * @get('/logout')
         * @name('logout')
         * @middlewares(web, auth)
         */
        auth()->logout();
        session()->flush();
        cache()->clear();

        return redirect('/');
    }

    public function register(RegisterRequest $request)
    {
        /**
         * @post('/register')
         * @name('')
         * @middlewares(web, throttle:10,1440, guest)
         */
        $driver = $this->checkIsPhoneOrEmail($request->phone);
        if (UserRepo::findByPhoneOrEmail($request->phone)) {
            return response(['message' => 'کاربری با این شماره تلفن و یا ایمیل وجود دارد.'], 400);
        }

        event(new SendVerificationCode($request, $driver));

        return response(['message' => 'کد تایید با موفقیت ارسال شد.']);
    }

    public function verify(Request $request)
    {
        /**
         * @post('/verify')
         * @name('')
         * @middlewares(web, guest)
         */
        if ($request->verify != session('code')) {
            return response(['message' => 'کد وارده شده اشتباه است.'], 400);
        }
        UserRepo::createUserBySession();

        return response(['message' => 'با موفقیت ثبت نام شدید.']);
    }

    public function resetPassword(RecoverRequest $request)
    {
        /**
         * @post('/reset-password')
         * @name('')
         * @middlewares(web, throttle:5,1440, guest)
         */
        $user = UserRepo::findByPhoneOrEmail($request->phone);
        if (! $user) {
            return response(['message' => 'کاربری با این اطلاعات وجود ندارد.'], 400);
        }
        $pass = UserRepo::modifyUser($user);
        event(new ResetPasswordEvent($request->phone, $pass, $this->checkIsPhoneOrEmail($request->phone)));

        return response(['message' => 'رمز عبور جدید شما تا لحظاتی دیگر ارسال می شود.']);
    }

    private function checkIsPhoneOrEmail($var)
    {
        $email = \Validator::make(['phone' => $var], ['phone' => 'email']);
        $phone = \Validator::make(['phone' => $var], ['phone' => 'numeric|digits:11']);

        if (! $email->fails()) {
            return 'email';
        } elseif (! $phone->fails()) {
            return 'sms';
        }

        return null;
    }

    public function profile()
    {
        /**
         * @get('/profile')
         * @name('')
         * @middlewares(web, auth)
         */
        $user = cache('user');

        $profile = $user->profile;
        if (! $profile) {
            $profile = new Profile();
            $user->profile()->save($profile);
            $user->profile = $profile;
        }
        $user->profile->birth = $user->profile->birth ? Jalalian::forge($user->profile->birth)->format('Y/m/d') : null;

        return view('main.profile', compact('user'));
    }

    public function uploadAvatar(Request $request)
    {
        /**
         * @post('/upload-avatar')
         * @name('')
         * @middlewares(web, auth)
         */
        $user = cache('user');
        $avatar = '/storage/' . $request->file('file')->store('avatars', 'public');
        File::delete(public_path($user->profile->avatar));
        $user->profile()->update(['avatar' => $avatar]);

        return response([
            'message' => 'با موفقیت تغییر یافت.',
            'avatar' => $avatar,
        ]);
    }

    public function changeProfile(ProfileRequest $request)
    {
        /**
         * @post('/profile-change')
         * @name('')
         * @middlewares(web, auth)
         */
        $user = cache('user');
        $profile = $user->profile;
        $birth = $profile['birth'];

        if (!$birth) {
            $birth = Jalalian::fromFormat('Y/m/d', $request->profile['birth'])->toCarbon();
        }

        $profile->update([
            'bio' => $request->profile['bio'],
            'birth' => $birth,
        ]);

        $user->update([
            'name' => $request->name,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response([
            'message' => 'با موفقیت تغییر یافت.',
        ]);
    }
}
