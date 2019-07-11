<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 使用 Dingo\Api\Routing\Router 注册。
$api = app('Dingo\Api\Routing\Router');

// DingoApi 提供了 version 方法，用来进行版本控制，第一个参数是版本名称，version 中的就是不用版本的路由

// $api->get('version', function() {
//     return response('this is version v1');
// });
// $api->version('v1', function($api) {
//     $api->get('version', function() {
//         return response('this is version v1');
//     });
// });

$api->version('v2', function($api) {
    $api->get('version', function() {
        return response('这是 version v2');
    });
});

// 使 v1 版本的路由都会指向 App\Http\Controllers\Api
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings']
], function($api) {
    // 通过中间件 api.throttle 设置接口调用限制，限定为 1 分钟 1 次，
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 10,
        'expires' => 1,
    ], function($api) {
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            -> name('api.verificationCodes.store');
        // 用户注册
        $api->post('users', 'UsersInfoController@store')
            ->name('api.users.store');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => 600,
        'expires' => 1,
    ], function ($api) {
        // 游客可以访问的接口

        // 需要 token 验证的接口
        // DingoApi 为我们准备好了 api.auth 中间件，用来区分哪些接口需要验证 token
        $api->group(['middleware' => 'api.auth'], function($api) {
            // 当前登录用户信息
            $api->get('user', 'UsersInfoController@me')
                ->name('api.user.show');
            // 编辑登录用户信息
            $api->patch('user', 'UsersController@update')
                ->name('api.user.update');
            // 图片资源
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');
            // 发布话题
            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');
            // 修改话题
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');
            // 删除话题
            $api->delete('topics/{topic}', 'TopicsController@destroy')
                ->name('api.topics.destroy');
            // 发布回复
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.topics.replies.store');
            // 删除回复
            $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('api.topics.replies.destroy');
            // 通知列表
            $api->get('user/notifications', 'NotificationsController@index')
                ->name('api.user.notifications.index');
            // 通知统计
            $api->get('user/notifications/stats', 'NotificationsController@stats')
                ->name('api.user.notifications.stats');
            // 标记消息通知为已读
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');
            // 当前登录用户权限
            $api->get('user/permissions', 'PermissionsController@index')
                ->name('api.user.permissions.index');
        });
    });

    // 获取分类
    $api->get('categories', 'CategoriesController@index')
        ->name('api.categories.index');

    // 获取话题列表
    $api->get('topics', 'TopicsController@index')
        ->name('api.topics.index');

    // 获取话题详情
    $api->get('topics/{topic}', 'TopicsController@show')
        ->name('api.topics.show');

    // 获取某个用户的话题列表
    $api->get('users/{user}/topics', 'TopicsController@userIndex')
    ->name('api.users.topics.index');

    // 话题回复列表
    $api->get('topics/{topic}/replies', 'RepliesController@index')
        ->name('api.topics.replies.index');

    // 右侧资源推荐
    $api->get('links', 'LinksController@index')
        ->name('api.links.index');

    // 图片资源
    $api->post('images', 'ImagesController@store')
        ->name('api.images.store');

    // 登录
    $api->post('authorizations', 'AuthorizationsController@store')
        ->name('api.authorizations.store');

    // 刷新token
    $api->put('authorizations/current', 'AuthorizationsController@update')
        ->name('api.authorizations.update');
    // 删除token
    $api->delete('authorizations/current', 'AuthorizationsController@destroy')
        ->name('api.authorizations.destroy');

    // 图片验证码
    $api->post('captchas', 'CaptchasController@store')
        ->name('api.captchas.store');

    // 测试接口
    $api->get('version', function() {
        return response('这是 version v1');
    });
});

// $api->version('v1', function($api) {
//     $api->get('test', function(){
//         return 'hello';
//     });
// });