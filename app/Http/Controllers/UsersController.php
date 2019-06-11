<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    // __construct 是 PHP 的构造器方法，当一个类对象被创建之前该方法将会被调用。
    public function __construct()
    {
        // 我们在 __construct 方法中调用了 middleware 方法，该方法接收两个参数
        // 第一个为中间件的名称，第二个为要进行过滤的动作。
        // 通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤
        // 除了此处指定的动作 'show', 'create', 'store' 以外，所有其他动作都必须登录用户才能访问
        // 相反的还有 only 白名单方法，将只过滤指定动作
        // 提倡在控制器 Auth 中间件使用中，首选 except 方法，这样的话，当你新增一个控制器方法时，默认是安全的
        // Auth 中间件在过滤指定动作时，若该用户未通过身份验证（未登录用户），默认将会被重定向到 /login 登录页面
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);
        // 可以使用 Auth 中间件提供的 guest 选项
        // 用于指定一些只允许未登录用户访问的动作
        // 只让未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    public function index()
    {
        // 取出所有用户
        // $users = User::all();
        // 每页取出 10 条数据
        // 当你访问 /users?page=2 链接时，访问的第二页数据
        // 在上面代码我们使用 paginate 方法来指定每页生成的数据数量为 10 条
        // 即当我们有 50 个用户时，用户列表将被分为五页进行展示
        // 在调用 paginate 方法获取用户列表之后，便可以通过以下代码在用户列表页上渲染分页链接
        // {!! $users->render() !!}
        $users = User::paginate(2);
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        // 之前进行了模型关联，因此通过 $user->statuses() 取出一个用户的所有微博
        $statuses = $user->statuses()
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
        return view('users.show', compact('user', 'statuses'));
        // 将用户对象 $user 通过 compact 方法转化为一个关联数组
        // 作为第二个参数传递给 view 方法，将数据与视图进行绑定
        // show 方法添加完成之后，我们便能在视图中使用 user 变量来访问通过
        // return view('users.show', compact('user'));
    }

    // 利用了『隐性路由模型绑定』功能，直接读取对应 ID 的用户实例 $user
    // 将查找到的用户实例 $user 与编辑视图进行绑定
    public function edit(User $user)
    {
        // authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
        // update 是指授权类里的 update 授权方法，$user 对应传参 update 授权方法的第二个参数
        // update 授权方法时候提起的，调用时，默认情况下，我们 不需要 传递第一个参数
        // 也就是当前登录用户至该方法内，因为框架会自动加载当前登录用户
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // update 方法接收两个参数
    // 第一个为自动解析用户 id 对应的用户实例对象
    // 第二个则为更新用户表单的输入数据
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
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
    public function destroy(User $user)
    {
        // 首先会根据路由发送过来的用户 id 进行数据查找，查找到指定用户之后再调用 Eloquent 模型提供的 delete 方法对用户资源进行删除，成功删除后在页面顶部进行消息提示。最后将用户重定向到上一次进行删除操作的页面，即用户列表页
        // 验证当前是否是管理员
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
