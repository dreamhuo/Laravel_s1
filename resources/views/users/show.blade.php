@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card ">
      <img class="card-img-top" src="https://iocaffcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600" alt="{{ $user->name }}">
      <div class="card-body">
            <h5><strong>个人简介</strong></h5>
            <p>{{ $user->introduction }} </p>
            <hr>
            <h5><strong>注册于</strong></h5>
            <!-- 时间戳友好的输出 -->
            <!-- 时间戳 created_at 和 updated_at 作为模型属性被调用时，都会自动转换为 Carbon 对象-->
            <!-- 下面我们使用 Laravel 自带的 dd() 辅助函数验证一下 dd($user->created_at) (需要双大括号) -->
            <!-- Carbon 是 PHP 知名的日期和时间操作扩展，Laravel 框架中使用此扩展来处理时间、日期相关的操作。diffForHumans 是 Carbon 对象提供的方法，提供了可读性越佳的日期展示形式 -->
            <p>{{ $user->created_at->diffForHumans() }}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card ">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

    {{-- 用户发布的内容 --}}
    <div class="card ">
      <div class="card-body">
        暂无数据 ~_~
      </div>
    </div>

  </div>
</div>
@stop