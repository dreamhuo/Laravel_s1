<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ReplyObserver
{
    public function saving(Reply $reply)
    {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        $log = new Logger('register');
        $log->pushHandler(new StreamHandler(storage_path('RepliesObserver/reg_test.log'),Logger::INFO) );
        $log->addInfo('共有几条回复:'.$reply->topic->replies->count());
    }
}