<?php

namespace App\Http\Requests\Api;

class VerificationCodeRequest extends FormRequest
{
    public function rules()
    {
        // 必须提交 phone 参数，必须是一个合法的电话格式，而且该手机号未注册过
        return [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                'unique:users'
            ],
            'captcha_key' => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => '手机号不能为空',
            'phone.regex' => '手机号错误',
            'phone.unique' => '手机号已注册',
            'captcha_key' => '图片验证码 key',
            'captcha_code' => '图片验证码',
        ];
    }
}