<?php

// namespace 代表的是 命名空间
// 可以把命名空间理解为文件路径，把变量名理解为文件。
// 当我们在不同路径分别存放了相同的文件时，系统就不会出现冲突
namespace App\Http\Controllers;
// 用 use 来引用在 PHP 文件中要使用的类，引用之后便可以对其进行调用
use Illuminate\Http\Request;

// StaticPagesController 类继承了父类 App\Http\Controllers\Controller
class StaticPagesController extends Controller
{
    public function home()
    {
        return view('static_pages/home');
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