<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
	public function show ()
	{
		return view('register');
	}

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
		return view('verify');
	}

	public function verify (Request $request)
	{
		if($request->verify != session('code')) return redirect(route('alert' , ['alert' => 'کد وارده شده اشتباه است.لطفا به صفحه ثبت نام بازگشته و دوباره امتحان کنید','showBtn' => 'show']));
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
			return redirect(route('alert' , ['alert' => 'مشکلی در ثبت نام به وجود آمده لطفا دوباره امتحان کنید.' , 'showBtn' => 'show']));
		session()->forget('code');
		return redirect(route('alert' , ['alert' => 'با موفقیت ثبت نام شدید.' ,'showBtn' => 'show']));
	}

	public function recovery ()
	{
		return view('recovery');
	}

	public function checkRecovery (Request $request)
	{
		$request->validate([
			'username' => 'required|string' ,
			'phone' => 'required|string|min:10' ,
		]);
		$user = User::where('phone',$request->phone)->where('handle',$request->username)->first();
		if(!$user)
			return redirect(route('alert' , ['alert' => 'کاربری با این اطلاعات وجود ندارد.']));
		$pass = random_int(100000000 , 999999999);
		$user->passhash = Hash::make($pass);
		if($user->save())
		{
			$sender = "10003334444";
			$receptor = (string) $request->phone;
			$message = "رمز جدید شما : ".$pass." تیزویران ";
			$api = new \Kavenegar\KavenegarApi("39796B4F63394667334B777230544D3451622F357159697169382F6368754B7674664B6B2F7A63707845553D");
			$api->Send($sender , $receptor , $message);
			return redirect(route('alert' , ['alert' => 'رمز عبور جدید شما تا لحظاتی دیگر ارسال می شود.']));
		}
		return redirect(route('alert' , ['alert' => 'متاسفانه مشکلی در انجام عملیات به وجود آمده است.']));

	}

	public function sms ()
	{
        $sender = "10003334444";
		$receptor = (string) session('data')['phone'];
		$message = "کد تایید شما : ".session('code')." تیزویران ";
        $api = new \Kavenegar\KavenegarApi("39796B4F63394667334B777230544D3451622F357159697169382F6368754B7674664B6B2F7A63707845553D");
		$api->Send($sender , $receptor , $message);
	}
}
