<?php

namespace App\Models;
// 消息通知相关功能引用
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// 是授权相关功能的引用
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 添加了 fillable 在过滤用户提交的字段，只有包含在该属性中的字段才能够被正常更新
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * 当我们需要对用户密码或其它敏感信息在用户实例通过数组或 JSON 显示时进行隐藏，则可使用 hidden 属性
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 为 gravatar 方法传递的参数 size 指定了默认值 100；
    public function gravatar($size = '100')
    {
        // 通过 $this->attributes['email'] 获取到用户的邮箱；
        // 使用 trim 方法剔除邮箱的前后空白内容；
        // 用 strtolower 方法将邮箱转换为小写；
        // 将小写的邮箱使用 md5 方法进行转码；
        $hash = md5(strtolower(trim($this->attributes['email'])));
        // 将转码后的邮箱与链接、尺寸拼接成完整的 URL 并返回；
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
