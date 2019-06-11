<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');
Route::get('signup', 'UsersController@create')->name('signup');

// Laravel 提供了 resource 方法来定义用户资源路由
// resource 方法将遵从 RESTful 架构为用户资源生成路由。
// 该方法接收两个参数，第一个参数为资源名称，第二个参数为控制器名称
Route::resource('users', 'UsersController');
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

// 使用 resource 方法来定义微博路由，则会生成完整的符合 RESTful 架构的路由
// 但我们完成微博的创建和删除只需要两个动作，因此我们可以对 resource 传参 only 键指定只生成某几个动作的路由
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);
