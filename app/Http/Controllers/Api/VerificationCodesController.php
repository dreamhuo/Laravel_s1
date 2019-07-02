<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Support\Facades\Cache;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request)
    {
        $phone = $request->phone;

        // 这里是获取的值
        // return $this->response->array([
        //     'key' => Cache::get('verificationCode_TRxxArRgY9IIswE')
        // ]);

        // 生成4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        // 返回给前端的 key
        $key = 'verificationCode_'.str_random(15);
        // 设置过期时间为 10 分钟
        $expiredAt = now()->addMinutes(10);
        // 在缓存中存储这个 key 对应的手机以及验证码
        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        // 将 key 以及 过期时间 返回给客户端
        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}