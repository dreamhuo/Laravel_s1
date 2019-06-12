<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    // 都需要用户登录之后才能进行操作，因此我们在 __construct 方法里为这两个动作都加上请求过滤
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        // 用户不能对自己进行关注和取消关注
        // 因此我们在 store 和 destroy 方法中都对用户身份做了授权判断
        $this->authorize('follow', $user);
        // 利用 isFollowing 方法来判断当前用户是否已关注了要进行操作的用户
        if ( ! Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        $this->authorize('follow', $user);

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }
}
