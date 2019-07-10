<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Models\Reply;
use App\Transformers\ReplyTransformer;
use App\Http\Requests\Api\ReplyRequest;

class RepliesController extends Controller
{
    // 发布回复
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->content;
        // 当更新 belongsTo 关联时，可以使用 associate 方法。此方法将会在子模型中设置外键
        // 这里是回复与话题相关联
        $reply->topic()->associate($topic);
        // 回复的用户与当前用户相关联
        $reply->user()->associate($this->user());
        // 保存回复
        $reply->save();

        // 将当前回复通过 ajax 返回
        return $this->response->item($reply, new ReplyTransformer())
            ->setStatusCode(201);
    }
    // 删除回复
    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id != $topic->id) {
            return $this->response->errorBadRequest();
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        // return $this->response->noContent();
        return $this->response->array([
            'status' => 1,
            'message' => '删除回复成功！',
        ])->setStatusCode(201);
    }

    // 获取回复列表
    public function index(Topic $topic)
    {
        // 通过 models 里获取一条回复对应的多条回复
        $replies = $topic->replies()->paginate(20);

        return $this->response->paginator($replies, new ReplyTransformer());
    }
}