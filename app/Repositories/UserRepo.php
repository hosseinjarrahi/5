<?php

namespace App\Repositories;

use App\Events\ResetPasswordEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepo
{

  public static function createUserBySession()
  {
    $user = new User();
    $data = session('data');
    $user->type = $data['type'];
    $user->password = Hash::make($data['password']);
    $user->phone = $data['phone'];
    $user->email = $data['email'];
    $user->name = $data['name'] ?? '';
    $user->verified_at = now();
    $user->save();
    session()->forget('code');
  }

  public static function modifyUser($user)
  {
    $pass = random_int(100000000, 999999999);
    $user->password = Hash::make($pass);
    $user->save();
    return $user;
  }

  public static function findByPhoneOrEmail($var){
    return User::where('email', $var)
              ->orWhere('phone', $var)
              ->first();
  }

}
