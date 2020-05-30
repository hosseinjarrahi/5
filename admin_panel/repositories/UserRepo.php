<?php

namespace Admin\repositories;

use App\Models\User;
use Illuminate\Support\Facades\File;

class UserRepo
{
    public static function paginate($perPage = 10)
    {
        return User::paginate($perPage);
    }

    public static function delete($user)
    {
        if ($user->profile) {
            File::delete(public_path($user->profile->avatar));
            $user->profile()->delete();
        }

        return $user->delete();
    }
}
