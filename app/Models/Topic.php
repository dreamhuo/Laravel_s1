<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'body' => '暂未设置内容…',
    ];
    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug',
    ];
    public function category()
    {
        // 一个话题属于一个分类
        // 属于 一对一 对应关系，故我们使用 belongsTo() 方法来实现
        return $this->belongsTo(Category::class);
    }
}
