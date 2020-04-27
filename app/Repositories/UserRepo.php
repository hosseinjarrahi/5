<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepo
{
    public static function createUserBySession()
    {
        $data = session('data');
        $user = new User();
        $user->type = $data['type'];
        $user->password = Hash::make($data['password']);
        $user->phone = $data['phone'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->name = $data['name'] ?? '';
        $user->verified_at = now();
        $user->save();
        $user->profile()->save(new Profile(['bio' => 'درباره من ...']));
        auth()->login($user);
        session()->forget('code');
    }

    public static function modifyUser($user)
    {
        $pass = random_int(100000000, 999999999);
        $user->password = Hash::make($pass);
        $user->save();

        return $pass;
    }

    public static function findByPhoneOrEmail($var)
    {
        return User::where('email', $var)->orWhere('phone', $var)->first();
    }

    public static function getWithNormFromExam($exam)
    {
        return $exam->users()->withPivot(['norm'])->get();
    }

    public static function bestStudents()
    {
        return User::bestStudents()->get();
    }
}
