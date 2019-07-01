<?php

namespace App\Http\Requests\Api;

//  FormRequest 是 DingoApi 为我们提供的基类。
use Dingo\Api\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }
}