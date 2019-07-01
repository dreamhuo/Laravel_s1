<?php

namespace App\Http\Requests\Api;

//  FormRequest 是 DingoApi 为我们提供的基类。
use Dingo\Api\Http\FormRequest;

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
            ]
        ];
    }
}