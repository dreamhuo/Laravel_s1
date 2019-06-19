<?php

namespace App\Models;
// 消息通知相关功能引用
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

// 是授权相关功能的引用
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Str;
use Auth;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class User extends Authenticatable
{
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
        $log = new Logger('register');
        $log->pushHandler(new StreamHandler(storage_path('logs/laravelNotify.log'),Logger::INFO) );
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $log->addInfo('notification_count');
            $this->increment('notification_count');
            $log->addInfo('notification_count:::'.$this->notification_count);
        }
        $this->laravelNotify($instance);
    }
}
