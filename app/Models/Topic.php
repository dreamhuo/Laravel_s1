<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id', 'category_id', 'reply_count',
        'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug',
    ];

    public function category()
    {
        // 一个话题属于一个分类
        // 属于 一对一 对应关系，故我们使用 belongsTo() 方法来实现
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        // 一个话题拥有一个作者
        // 属于 一对一 对应关系，故我们使用 belongsTo() 方法来实现
        return $this->belongsTo(User::class);
    }
}
