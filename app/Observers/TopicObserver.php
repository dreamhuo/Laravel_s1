<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    // 监听一个帖子删除时，把这个帖子下面的回复也全删除
    public function deleted(Topic $topic)
    {
        // 在模型监听器中，数据库操作需避免再次触发 Eloquent 事件，以免造成联动逻辑冲突。所以这里我们使用了 DB 类进行操作
        // 若这里再通过 Eloquent 事件 去删除回复，就会触发更新帖子回复数，而这时帖子已删除不存在，所以会冲突
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}