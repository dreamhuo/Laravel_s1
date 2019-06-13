<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // authorize() 方法是表单验证自带的另一个功能 —— 权限验证
    // 此处我们 return true; ，意味所有权限都通过即可
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // rules() 方法内，对三个字段设置了不同的验证规则
    // name.required —— 验证的字段必须存在于输入数据中，而不是空。
    // name.between —— 验证的字段的大小必须在给定的 min 和 max 之间。
    // name.regex —— 验证的字段必须与给定的正则表达式匹配。
    // name.unique —— 验证的字段在给定的数据库表中必须是唯一的。
    // email.required —— 同上
    // email.email —— 验证的字段必须符合 e-mail 地址格式。
    // introduction.max —— 验证中的字段必须小于或等于 value。
    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
        ];
    }
    // 自定义表单的提示信息，修改 UserRequest，新增方法 messages()
    // messages() 方法是 表单请求验证（FormRequest）一个很方便的功能，允许我们自定义具体的消息提醒内容，键值的命名规范 —— 字段名 + 规则名称，对应的是消息提醒的内容
    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
        ];
    }
}
