<?php

namespace App\Http\Requests\Api;

class AuthorizationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }
    public function attributes()
    {
        return [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
        ];
    }
}