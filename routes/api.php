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
$api->version('v1', function($api) {
    $api->get('version', function() {
        return response('this is version v1');
    });
});

$api->version('v2', function($api) {
    $api->get('version', function() {
        return response('this is version v2');
    });
});

// 使 v1 版本的路由都会指向 App\Http\Controllers\Api
// $api->version('v1', [
//     'namespace' => 'App\Http\Controllers\Api'
// ], function($api) {
//     // 短信验证码
//     $api->post('verificationCodes', 'VerificationCodesController@store') -> name('api.verificationCodes.store');
//     $api->get('version', function() {
//         return response('this is version v1');
//     });
// });

// $api->version('v1', function($api) {
//     $api->get('test', function(){
//         return 'hello';
//     });
// });