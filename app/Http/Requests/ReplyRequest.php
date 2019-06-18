<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

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
        // messages() 方法中新增了头像出错时的提示信息。
        return [
            'content.required' =>'内容不能为空',
            'content.min' => '内容最少2个字符',
        ];
    }
}