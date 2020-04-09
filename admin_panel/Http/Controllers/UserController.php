<?php

namespace Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(9);
        return view('Admin::users',compact('users'));
    }

    public function destroy(User $user)
    {
        if($user->profile) {
            File::delete(public_path($user->profile->avatar));
            $user->profile()->delete();
        }
        $user->delete();
        return back();
    }
}