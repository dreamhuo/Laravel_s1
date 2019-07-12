<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // if (app()->isLocal()) {
        //     $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        // }

        \API::error(function  (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException  $exception)  {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(404,  '未找到页面');
        });
        \API::error(function  (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException  $exception)  {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(405,  '页面错误');
        });
        \API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
            abort(403, '您没有权限');
        });
        // \API::error(function  (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $exception)  {
        //     throw new \Symfony\Component\HttpKernel\Exception\HttpException(401,  '没有权限');
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
    }
}
