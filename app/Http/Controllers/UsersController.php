<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        // 在 __construct 方法中调用了 middleware 方法，该方法接收两个参数
        // 第一个为中间件的名称，第二个为要进行过滤的动作
        // 通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤
        $this->middleware('auth', ['except' => ['show']]);
    }

    // Laravel 会自动解析定义在控制器方法（变量名匹配路由片段）中的 Eloquent 模型类型声明。
    // 在上面代码中，由于 show() 方法传参时声明了类型 —— Eloquent 模型 User，对应的变量名 $user 会匹配路由片段中的 {user}
    // 这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
    // 此功能称为 『隐性路由模型绑定』，是『约定优于配置』设计范式的体现，同时满足以下两种情况，此功能即会自动启用：
    // 1). 路由声明时必须使用 Eloquent 模型的单数小写格式来作为 路由片段参数，User 对应 {user}：
    // 在使用资源路由 Route::resource('users', 'UsersController'); 时，默认已经包含了下面的声明
    // 2). 控制器方法传参中必须包含对应的 Eloquent 模型类型 提示，并且是有序的
    // 当请求 http://larabbs.test/users/1 并且满足以上两个条件时，Laravel 将会自动查找 ID 为 1 的用户并赋值到变量 $user 中，如果数据库中找不到对应的模型实例，会自动生成 HTTP 404 响应
    public function show(User $user)
    {
        // 将用户对象变量 $user 通过 compact 方法转化为一个关联数组
        // 并作为第二个参数传递给 view 方法，将变量数据传递到视图中
        return view('users.show', compact('user'));
    }

    // edit() 方法接受 $user 用户作为传参，也就是说当 URL 是 http://larabbs.test/users/1/edit 时，读取的是 ID 为 1 的用户。
    // 这里使用的是与 show() 方法一致的 『隐性路由模型绑定』 开发范式
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // 修改用户信息
    // 表单请求验证（FormRequest）的工作机制，是利用 Laravel 提供的依赖注入功能
    // 在 update() 方法声明中，传参 UserRequest。这将触发表单请求类的自动验证机制，验证发生在 UserRequest 中，并使用此文件中方法 rules() 定制的规则，只有当验证通过时，才会执行 控制器 update() 方法中的代码。否则抛出异常，并重定向至上一个页面，附带验证失败的信息
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        // 在 Laravel 中，我们可直接通过 请求对象（Request） 来获取用户上传的文件
        // 第一种方法
        // $file = $request->file('avatar');
        // 第二种方法，可读性更高
        // $file = $request->avatar;
        // Laravel 的『用户上传文件对象』底层使用了 Symfony 框架的 UploadedFile 对象进行渲染，为我们提供了便捷的文件读取和管理接口

        // $data = $request->all(); 赋值 $data 变量，以便对更新数据的操作
        $data = $request->all();
        // 若有头像，对头像做存储，并把路径保存到数据库里
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            // if ($result) 的判断是因为 ImageUploadHandler 对文件后缀名做了限定，不允许的情况下将返回 false
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
