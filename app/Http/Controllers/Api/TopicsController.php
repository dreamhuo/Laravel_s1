<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\TopicTransformer;
use App\Http\Requests\Api\TopicRequest;

class TopicsController extends Controller
{
    // 创建帖子
    public function store(TopicRequest $request, Topic $topic)
    {
        // 已经有一个模型实例，你可以传递一个数组给 fill 方法来赋值
        // $flight->fill(['name' => 'Flight 22']);
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();

        return $this->response->item($topic, new TopicTransformer())
            ->setStatusCode(201);
    }

    // 修改帖子
    public function update(TopicRequest $request, Topic $topic)
    {
        // 基类的控制器提供了一个有用的 authorize 方法；
        // 接收你想授权的动作和相关的模型作为参数。如果这个动作没有被授权， authorize 方法会抛出一个 Illuminate\Auth\Access\AuthorizationException 的异常，然后 Laravel 默认的异常处理器会将这个异常转化成带有 403 状态码的 HTTP 响应
        // 会调 app/policies/TopicsPolidy.php 里 update 方法
        // update 方法会调 Models/user.php isAuthorOf 方法，判断当前帖子是否属于这个用户
        $this->authorize('update', $topic);
        // return $this->response->array([
        //     'key' => $request -> title,
        //     'code' => $request -> body,
        //     'expired_at' => $request -> category_id,
        // ])->setStatusCode(201);
        $topic->update($request->all());
        return $this->response->item($topic, new TopicTransformer());
    }

    // 删除话题
    public function destroy(Topic $topic)
    {
        // 话题删除接口 会通过 授权策略 提供的 authorize 方法来判断了用户是否具备某个操作的权限
        $this->authorize('destroy', $topic);

        $topic->delete();
        // return $this->response->noContent();
        return $this->response->array([
            'status' => 1,
            'message' => '删除话题成功！',
        ])->setStatusCode(201);
    }

    // 获取话题列表
    public function index(Request $request, Topic $topic)
    {
        // models 中定义 query 方法用来模型检索
        $query = $topic->query();

        // 若传了分类 id ，则把分类 id 做为查询条件
        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }
        // 不同排序使用不同的数据库读取逻辑
        switch ($request->order) {
            case 'recent':
                // 这里调用的是 app\Models\Topic.php 里的私有方法 scopeRecent
                $query->recent();
                break;
            default:
                // 这里调用的是 app\Models\Topic.php 里的私有方法 scopeRecentReplied
                $query->recentReplied();
                break;
        }

        $topics = $query->paginate(20);

        return $this->response->paginator($topics, new TopicTransformer());
    }
    // 获取单个用户话题列表
    public function userIndex(User $user, Request $request)
    {
        $topics = $user->topics()->recent()->paginate(20);
        return $this->response->paginator($topics, new TopicTransformer());
    }

    // 话题详情接口
    public function show(Topic $topic)
    {
        return $this->response->item($topic, new TopicTransformer());
    }
}