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

    // 利用了『隐性路由模型绑定』功能，直接读取对应 ID 的用户实例 $user
    // 将查找到的用户实例 $user 与编辑视图进行绑定
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // update 方法接收两个参数
    // 第一个为自动解析用户 id 对应的用户实例对象
    // 第二个则为更新用户表单的输入数据
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        // $user->update([
        //     'name' => $request->name,
        //     'password' => bcrypt($request->password),
        // ]);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
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
        // 可以借助 Request 使用下面的这种方式来获取 name 的值
        // $name = $request->name;
        // 需要获取用户输入的所有数据，可使用：
        // $data = $request->all();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        // 要让一个已认证通过的用户实例进行登录，可以使用:
        Auth::login($user);
        // 而当我们想存入一条缓存的数据，让它只在下一次的请求内有效时
        // 则可以使用 flash 方法。flash 方法接收两个参数
        // 第一个为会话的键
        // 第二个为会话的值，我们可以通过下面这行代码的为会话赋值。
        // 之后我们可以使用 session()->get('success') 通过键名来取出对应会话中的数据
         session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        // 用户模型 User::create() 创建成功后会返回一个用户对象
        // 并包含新注册用户的所有信息。
        // 我们将新注册用户的所有信息赋值给变量 $user，并通过路由跳转来进行数据绑定。
        return redirect()->route('users.show', [$user]);
    }
}
