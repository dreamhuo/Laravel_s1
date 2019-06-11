<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    public function create()
    {
        return view('sessions.create');
    }
    public function store(Request $request)
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

       // Auth::attempt() 方法可接收两个参数
       // 第一个参数为需要进行用户身份认证的数组
       // 第二个参数为是否为用户开启『记住我』功能的布尔值
       if (Auth::attempt($credentials, $request->has('remember'))) {
           // 登录成功后的相关操作
          session()->flash('success', '欢迎回来！');
          // return redirect()->route('users.show', [Auth::user()]);
          // redirect() 实例提供了一个intended方法
          // 该方法可将页面重定向到上一次请求尝试访问的页面上
          // 并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
          $fallback = route('users.show', Auth::user());
          return redirect()->intended($fallback);
       } else {
           // 登录失败后的相关操作
          session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
          return redirect()->back()->withInput();
       }

       return;
    }
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
