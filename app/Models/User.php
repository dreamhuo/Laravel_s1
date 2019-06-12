<?php

namespace App\Models;
// 消息通知相关功能引用
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// 是授权相关功能的引用
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Str;

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

    // boot 方法会在用户模型类完成初始化之后进行加载，因此我们对事件的监听需要放在该方法中。
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    // 由于一个用户拥有多条微博，因此在用户模型中我们使用了微博动态的复数形式 statuses 来作为定义的函数名
    // 指明一个用户拥有多条微博
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    // 首页局部列表
    public function feed()
    {
        // return $this->statuses()
        //             ->orderBy('created_at', 'desc');
        // 通过 followings 方法取出所有关注用户的信息
        // 再借助 pluck 方法将 id 进行分离并赋值给 user_ids
        $user_ids = $this->followings->pluck('id')->toArray();
        // 将当前用户的 id 加入到 user_ids 数组中
        array_push($user_ids, $this->id);
        // 使用 Laravel 提供的 查询构造器 whereIn 方法取出所有用户的微博动态并进行倒序排序
        // 使用了 Eloquent 关联的 预加载 with 方法，预加载避免了 N+1 查找的问题，大大提高了查询效率
        return Status::whereIn('user_id', $user_ids)
                              ->with('user')
                              ->orderBy('created_at', 'desc');
    }

    // 我们可以通过 followers 来获取粉丝关系列表
    public function followers()
    {
        // 在 Laravel 中我们使用 belongsToMany 来关联模型之间的多对多关系
        // 一个关注者可以有多个粉丝， 也可以关注多个粉丝
        // return $this->belongsToMany(User::Class);
        // 在 Laravel 中会默认将两个关联模型的名称进行合并，并按照字母排序，因此我们生成的关联关系表名称会是 user_user。我们也可以自定义生成的名称，把关联表名改为 followers
        // return $this->belongsToMany(User::Class, 'followers');
        // 通过传递额外参数至 belongsToMany 方法来自定义数据表里的字段名称
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    // 通过 followings 来获取用户关注人列表
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }

    // 关注动作
    public function follow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        // sync 方法在中间表上创建一个多对多记录
        // sync 方法会接收两个参数
        // 第一个参数为要进行添加的 id
        // 第二个参数则指明是否要移除其它不包含在关联的 id 数组中的 id，true 表示移除，false 表示不移除，默认值为 true
        // 由于我们在关注一个新用户的时候，仍然要保持之前已关注用户的关注关系，因此不能对其进行移除，所以在这里我们选用 false
        $this->followings()->sync($user_ids, false);
    }

    // 取消关注动作
    public function unfollow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        // detach 方法在中间表上移除一个记录
        $this->followings()->detach($user_ids);
    }

    // 判断当前登录的用户 A 是否关注了用户 B，只需判断用户 B 是否包含在用户 A 的关注人列表上即可。
    public function isFollowing($user_id)
    {
        // 这里我们将用到 contains 方法来做判断
        return $this->followings->contains($user_id);
    }
}
