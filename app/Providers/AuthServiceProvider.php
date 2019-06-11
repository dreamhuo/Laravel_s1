<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // 修改策略自动发现的逻辑
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // 动态返回模型对应的策略名称，如：// 'App\Model\User' => 'App\Policies\UserPolicy',
            // 授权策略定义完成之后，我们便可以通过在用户控制器中使用 authorize 方法来验证用户授权策略。
            // 默认的 App\Http\Controllers\Controller 类包含了 Laravel 的 AuthorizesRequests trait。
            // 此 trait 提供了 authorize 方法，它可以被用于快速授权一个指定的行为，当无权限运行该行为时会抛出 HttpException。
            return 'App\Policies\\'.class_basename($modelClass).'Policy';
        });
    }
}
