<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;
use Illuminate\Support\Facades\Cache;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-'.str_random(15);
        $phone = $request->phone;
        // controller 中，注入 CaptchaBuilder，通过它的 build 方法，创建出来验证码图片
        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2); // 设置过期时间为 2 分钟
        // 使用 getPhrase 方法获取验证码文本，跟手机号一同存入缓存。
        Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        // 返回 captcha_key，过期时间
        // 可以考虑在这里返回图片 url，例如 http://larabbs.test/captchas/{captcha_key}，然后访问该链接的时候生成并返回图片
        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()  // 使用 inline 方法获取的 base64 图片验证码
        ];

        return $this->response->array($result)->setStatusCode(201);
    }
}