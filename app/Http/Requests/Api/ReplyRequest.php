<?php

namespace App\Http\Requests\Api;

class ReplyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }
    public function messages()
    {
        return [
            'content.required' => '回复内容不能为空。',
            'content.min' => '回复内容最少两个字符',
        ];
    }
}