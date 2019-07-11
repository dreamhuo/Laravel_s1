<?php

namespace App\Transformers;

use App\Models\Reply;
use League\Fractal\TransformerAbstract;

class ReplyTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(Reply $reply)
    {
        return [
            'id' => $reply->id,
            'user_id' => (int) $reply->user_id,
            'topic_id' => (int) $reply->topic_id,
            'content' => $reply->content,
            'created_at' => (string) $reply->created_at,
            'updated_at' => (string) $reply->updated_at,
        ];
    }

    // 获取一条回复对应的回复
    public function includeUser(Reply $reply)
    {
        return $this->item($reply->user, new UserTransformer());
    }
}