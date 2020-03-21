<?php

namespace App\Http\Controllers;

use App\Dargah;
use App\Setting;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use SoapClient;

class PayController extends Controller
{
	public function purchases ()
	{
		$user = auth()->user();
		$pays = $user->pays() ?? [];
		$videos = new Collection();
		foreach ( $pays as $pay ) {
			$videos->push($pay->video());
		}
		$downloads = $user->downloads() ?? [];
		$products = new Collection();
		foreach ( $downloads as $download ) {
			$products->push($download->product());
		}

		return view('purchases',compact('videos','products'));
	}

	public function pay (User $user)
	{
		$s = Setting::first();
		$info = "
			<p><span>مبلغ قابل پرداخت : </span><span>$s->price</span><span> تومان </span></p>
			<p><span>مدت حق عضویت : </span><span>$s->time</span><span> روز </span></p>
			<p><span>تعداد دانلود ویدئو : </span><span>$s->video</span></p>
			<p><span>تعداد سوالات : </span><span>$s->product</span></p>
			<p><span>درگاه پرداخت : </span><span>زرین پال</span></p>
			<hr>
			<p><span>اطلاعات شما</span></p>
			<p><span>نام کاربری : </span><span>$user->handle</span></p>
		";
		$route = 'do.pay';
		session(['price' => $s->price]);
		return view('pay' , compact('info' , 'route' , 'user'));
	}

	public function doPay (Request $request)
	{
		$setting = Setting::first();
		$user = auth()->check() ? auth()->user() : User::find($request->id);
		session()->flash('pay_id' , $user->userid);
		$MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX'; //Required
		$Amount = $setting->price; //Amount will be based on Toman - Required
		$Description = 'خرید اشتراک در سایت تیزویران'; // Required
		$Email = $user->email; // Optional
//		$Mobile = '09123456789'; // Optional
		$CallbackURL = route('verify'); // Required


		$client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
		$result = $client->PaymentRequest(
			[
				'MerchantID' => $MerchantID,
				'Amount' => $Amount,
				'Description' => $Description,
				'Email' => $Email,
				'Mobile' => '',
				'CallbackURL' => $CallbackURL,
			]
		);
		//Redirect to URL You can do it also by creating a form
		if ($result->Status == 100) {
			return redirect('https://sandbox.zarinpal.com/pg/StartPay/'.$result->Authority);
		} else {
			return redirect(route('alert',['alert' => 'تراکنش با شکست مواجه شد.لطفا دوباره امتحان کنید']));
		}
	}

	public function verify (Request $request)
	{
		$user = auth()->check() ? auth()->user() : User::find(session('pay_id'));
		$setting = Setting::first();
		$MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
		$Amount = $setting->price; //Amount will be based on Toman
		$Authority = $request->Authority;

		if ($request->Status == 'OK') {

			$client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

			$result = $client->PaymentVerification(
				[
					'MerchantID' => $MerchantID,
					'Authority' => $Authority,
					'Amount' => $Amount,
				]
			);

			if ($result->Status == 100) {
				if(!$user->addPlan($setting->time,$result->RefID,$Authority))
					return redirect(route('alert',['alert' => 'این تراکنش تکراری است']));
				return redirect(route('alert',['alert' => 'تراکنش با موفقیت انجام شد.شماره تراکنش :' . $result->RefID]));
			} else {
				return redirect(route('alert',['alert' => 'تراکنش با شکست مواجه شد.لطفا دوباره امتحان کنید']));
			}
		} else {
			return redirect(route('alert',['alert' => 'تراکنش با شکست مواجه شد.لطفا دوباره امتحان کنید']));
		}
	}

	public function showPromote ()
	{
		return view('admin.promotion');
	}

	public function addPromote (Request $request)
	{
		$user = User::where('handle',$request->username)->first();
		if(empty($user)) return back()->withErrors(['notFound' => 'کاربر مورد نظر یافت نشد.']);
		$user->addPlan($request->days);
		return back()->withErrors(['success'=>'با موفقیت انجام شد']);
	}
//	public function video (Video $video)
//	{
//		$user = auth()->user();
//		$info = "
//			<p><span>مبلغ قابل پرداخت : </span><span>$video->price</span><span> تومان </span></p>
//			<p><span>نام ویدیو : </span><span>$video->title</span></p>
//			<p><span>درگاه پرداخت : </span><span>زرین پال</span></p>
//			<hr>
//			<p><span>اطلاعات شما</span></p>
//			<p><span>نام کاربری : </span><span>$user->handle</span></p>
//		";
//		$route = 'do.video.pay';
//		session(['video_price' => $video->price , 'video_id' => $video->id]);
//		return view('pay' , compact('info' , 'route'));
//	}
//
//	public function videoPay (Video $video)
//	{
//		$user = auth()->user();
//		if ( !$user->canDownloadVideo() )
//			return redirect(route('alert' , ['alert' => 'تعداد دانلود های مجاز شما به پایان رسیده است.برای مشاهده سوالات باید اشتراک تهییه کنید.']));
//		if ( !$user->hasVideo($video->id) )
//			(new Video(['user_id' => $user->userid , 'video_id' => $video->id , 'time' => time()]))->save();
//		return view('videoShow' , compact('video'));
//	}
}
