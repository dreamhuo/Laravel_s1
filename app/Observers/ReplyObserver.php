<?php

namespace App\Observers;

use App\Models\Reply;

use App\Notifications\TopicReplied;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }
    public function created(Reply $reply)
    {
        $reply->topic->updateReplyCount();

        // 通知话题作者有新的评论
        // notify() ，此方法接收一个通知实例做参数
        // 如果评论的作者不是话题的作者，才需要通知
        // if ( ! $reply->user->isAuthorOf($topic)) {
        //     $topic->user->notify(new TopicReplied($reply));
        // }
        // notify 方法会将 notification_count 进行 +1。所以 $this->user()->notification_count; 就是用户未读消息数
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}