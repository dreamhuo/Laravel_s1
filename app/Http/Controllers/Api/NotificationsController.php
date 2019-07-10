<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\NotificationTransformer;

class NotificationsController extends Controller
{
    public function index()
    {
        // 获取当前登录用户通知
        $notifications = $this->user->notifications()->paginate(20);

        return $this->response->paginator($notifications, new NotificationTransformer());
    }
    public function stats()
    {
        return $this->response->array([
            'unread_count' => $this->user()->notification_count,
        ]);
    }
    // 所有未读消息标记为已读
    public function read()
    {
        // markAsRead 方法 会将用户 notification_count 设置为 0，将所有未读消息设置为已读
        $this->user()->markAsRead();
        return $this->response->noContent();
    }
}