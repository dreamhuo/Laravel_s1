<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        // 将用户对象 $user 通过 compact 方法转化为一个关联数组
        // 作为第二个参数传递给 view 方法，将数据与视图进行绑定
        // show 方法添加完成之后，我们便能在视图中使用 user 变量来访问通过
        return view('users.show', compact('user'));
    }
    public function store(Request $request)
    {
        // validator 由 App\Http\Controllers\Controller 类中的 ValidatesRequests 进行定义
        // validate 方法接收两个参数，第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则
        // ** 可以使用 required 来验证用户名是否为空
        // ** 可以使用 min 和 max 来限制用户名所填写的最小长度和最大长度
        // ** 需要同时验证多个条件时，则可使用 | 对验证规则进行分割
        // ** 使用唯一性验证，这里是针对于数据表 users 做验证
        // ** 需要确保用户在输入密码时，保证两次输入的密码一致,可以使用 confirmed 来进行密码匹配验证
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        return;
    }
}
