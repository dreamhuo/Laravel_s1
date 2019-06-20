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

// class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmailContract
{
    // 获取到扩展包提供的所有权限和角色的操作方法
    use HasRoles;

    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // $fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则更新时会被忽略
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
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
}
