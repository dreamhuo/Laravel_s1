<?php

namespace App\Transformers;

use App\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    // 嵌套的额外资源 user 和 category
    // 通过 includeUser 和 includeCategory 确定，availableIncludes 中的每一个参数都对应一个具体的方法
    // 方法命名规则为 include + user 、 include + category 驼峰命名
    protected $availableIncludes = ['user', 'category'];

    public function transform(Topic $topic)
    {
        return [
            'id' => $topic->id,
            'title' => $topic->title,
            'body' => $topic->body,
            'user_id' => (int) $topic->user_id,
            'category_id' => (int) $topic->category_id,
            'reply_count' => (int) $topic->reply_count,
            'view_count' => (int) $topic->view_count,
            'last_reply_user_id' => (int) $topic->last_reply_user_id,
            'excerpt' => $topic->excerpt,
            'slug' => $topic->slug,
            'created_at' => (string) $topic->created_at,
            'updated_at' => (string) $topic->updated_at,
        ];
    }

    // 客户端需要引入额外的资源，由客户端提交的 include 参数指定，多个参数通过逗号分隔
    // 在 Transformer 中，我们可以使用：
    // $this->item () 返回单个资源
    // $this->collection () 返回集合资源
    // ***注意这里，获取权限 user.roles 才会获取角色 http://127.1.1.0:8082/api/topics?include=category,user.roles
    public function includeUser(Topic $topic)
    {
        return $this->item($topic->user, new UserTransformer());
    }

    public function includeCategory(Topic $topic)
    {
        return $this->item($topic->category, new CategoryTransformer());
    }
}