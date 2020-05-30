<?php

namespace Admin\Http\Controllers;

use App\Models\User;
use Admin\repositories\UserRepo;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function index()
    {
        /**
         * @get('/manager/user')
         * @name('admin.user.index')
         * @middlewares(web, auth, admin)
         */
        $users = UserRepo::paginate(9);

        return view('Admin::users', compact('users'));
    }

    public function destroy(User $user)
    {
        /**
         * @delete('/manager/user/{user}')
         * @name('admin.user.destroy')
         * @middlewares(web, auth, admin)
         */
        UserRepo::delete($user);

        return back();
    }
}
