<?php

namespace App\Models;
// 消息通知相关功能引用
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

// 是授权相关功能的引用
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Str;
use Auth;

// JWTSubject
use Tymon\JWTAuth\Contracts\JWTSubject;

// class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmailContract, JWTSubject
{
    // 获取到扩展包提供的所有权限和角色的操作方法
    // new一个 UserModel 对象,这些方法都可以使用了，
    // 1. user−>assignRole(‘writer′); 2.user->removeRole(‘writer’);
    // 3. user−>syncRoles(params);（这个方法我个人比较喜欢，当我们改变一个user的角色时候，用它最好不过了，它会把本来有的角色给你取消，然后赋予新的角色，这样特别省事，还能一次赋予好几个角色）
    // 4. role->givePermissionTo(‘edit articles’);
    // 5. role−>revokePermissionTo(‘editarticles′);
    // 6. role−>revokePermissionTo(‘editarticles′);     6.role->syncPermissions(params);
    use HasRoles;

    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    // guard_name 为权限守卫，只有权限表里 guard_name 为 admin 的，才能被用户用来附值
    protected $guard_name = 'admin';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // $fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则更新时会被忽略
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * 当我们需要对用户密码或其它敏感信息在用户实例通过数组或 JSON 显示时进行隐藏，则可使用 hidden 属性
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 一个用户对应多条回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // 一个用户对应多个帖子
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 消息通知类
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }
        $this->laravelNotify($instance);
    }

    // 清空消息
    public function markAsRead()
    {
        // 保存数据库
        $this->notification_count = 0;
        $this->save();
        // 清空缓存
        $this->unreadNotifications->markAsRead();
    }

    // getJWTIdentifier 返回了 User 的 id
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    // getJWTCustomClaims 是我们需要额外再 JWT 载荷中增加的自定义内容，这里返回空数组
    public function getJWTCustomClaims()
    {
        return [];
    }
}
