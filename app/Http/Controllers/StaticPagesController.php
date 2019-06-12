<?php

// namespace 代表的是 命名空间
// 可以把命名空间理解为文件路径，把变量名理解为文件。
// 当我们在不同路径分别存放了相同的文件时，系统就不会出现冲突
namespace App\Http\Controllers;
// 用 use 来引用在 PHP 文件中要使用的类，引用之后便可以对其进行调用
use Illuminate\Http\Request;
use Auth;

// StaticPagesController 类继承了父类 App\Http\Controllers\Controller
class StaticPagesController extends Controller
{
    public function home()
    {
        // 定义了一个空数组 feed_items 来保存微博动态数据
        $feed_items = [];
        // Auth::check() 来检查用户是否已登录
        if (Auth::check()) {
            // 对微博做了分页处理的操作，每页只显示 30 条微博
            $feed_items = Auth::user()->feed()->paginate(30);
        }

        return view('static_pages/home', compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}