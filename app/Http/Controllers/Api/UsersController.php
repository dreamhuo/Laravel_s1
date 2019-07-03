<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);

        if (!$verifyData) {
            // 验证码过期或者 verification_key 错误时，我们使用 $this->response->error 返回错误信息，状态码为 422，表明提交的参数错误
            return $this->response->error('验证码已失效', 422);
        }

        // 这里我们比对验证码是否与缓存中一致时，使用了 hash_equals 方法
        // hash_equals 是可防止时序攻击的字符串比较
        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            // 验证码错误的情况，我们使用 errorUnauthorized 返回，状态码为 401
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        Cache::forget($request->verification_key);

        return $this->response->created();
    }
}