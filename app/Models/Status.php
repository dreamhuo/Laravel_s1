<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 添加了 fillable 在过滤用户提交的字段，只有包含在该属性中的字段才能够被正常更新
     */
    protected $fillable = ['content'];
    public function user()
    {
        // 指明一条微博属于一个用户
        return $this->belongsTo(User::class);
    }
}