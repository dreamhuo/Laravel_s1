<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    // update 方法接收两个参数
    // 第一个参数默认为当前登录用户实例
    // 第二个参数则为要进行授权的用户实例
    // 当两个 id 相同时，则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作。
    // 如果 id 不相同的话，将抛出 403 异常信息来拒绝访问。
    public function update(User $currentUser, User $user)
    {
        // 我们并不需要检查 $currentUser 是不是 NULL。未登录用户，框架会自动为其 所有权限 返回 false
        // 调用时，默认情况下，我们 不需要 传递当前登录用户至该方法内，因为框架会自动加载当前登录用户
        return $currentUser->id === $user->id;
    }
    // destroy 删除用户动作相关的授权
    public function destroy(User $currentUser, User $user)
    {
        // 只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接
        // Laravel 授权策略提供了 @can Blade 命令，允许我们在 Blade 模板中做授权判断。接下来让我们利用 @can 指令，在用户列表页加上只有管理员才能看到的删除用户按钮。
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    public function follow(User $currentUser, User $user)
    {
        // 关注表单只有在授权策略通过时才显示，并且控制器关注和取消关注方法里，都需要做授权判断
        return $currentUser->id !== $user->id;
    }
}
