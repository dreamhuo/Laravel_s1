<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Support\Facades\Cache;

class UsersInfoController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);

        // return $this->response->array([
        //     'verifyData' => $verifyData,
        // ])->setStatusCode(201);

        if (!$verifyData) {
            // 验证码过期或者 verification_key 错误时，我们使用 $this->response->error 返回错误信息，状态码为 422，表明提交的参数错误
            return $this->response->error('验证码已失效', 422);
        }

        // 这里我们比对验证码是否与缓存中一致时，使用了 hash_equals 方法
        // hash_equals 是可防止时序攻击的字符串比较
        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            // 验证码错误的情况，我们使用 errorUnauthorized 返回，状态码为 401
            // 客户端在没有提供适当的身份认证凭证的时候向受保护的资源发送请求。
            // 他可能提供了错误的凭证或完全没有提供凭证。凭证可以是用户名和密码、
            // 一个 API Key 或者一个认证的 token-- 任何 API 质询时所期望的内容。
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

    public function me()
    {
        // Dingo\Api\Routing\Helpers ，提供了 user 方法，方便我们获取到当前登录的用户
        // 也就是 token 所对应的用户，$this->user() 等同于 \Auth::guard('api')->user()
        // 返回的是一个单一资源，所以使用 $this->response->item
        // 第一个参数是模型实例，第二个参数是刚刚创建的 transformer
        // return $this->response->array([
        //     'user' => $this->user(),
        // ])->setStatusCode(200);
        return $this->response->item(
            $this->user(),
            new UserTransformer()
        );

        // return $this->response->item($this->user(), new UserTransformer())
        // ->setMeta([
        //     'access_token' => \Auth::guard('api')->fromUser($this->user()),
        //     'token_type' => 'Bearer',
        //     'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        // ]) -> setStatusCode(201);

        // return $this->response->item($user, new UserTransformer()) -> setStatusCode(201);
    }
}