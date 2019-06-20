<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// 定义了一个 CreateUsersTable 类，并继承自 Migration 基类
class CreateUsersTable extends Migration
{
    // 运行迁移时，up 方法会被调用
    public function up()
    {
        // 调用 Schema 类的 create 方法来创建 users 表
        // create 方法会接收两个参数：一个是数据表的名称，另一个则是接收 $table（Blueprint 实例）的闭包
        // CreateUsersTable 类中通过 Blueprint 的实例 $table 为 users 表创建所需的数据库字段
        // increments 方法创建了一个 integer 类型的自增长 id
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable(); // Email 验证时间，空的话意味着用户还未验证邮箱
            $table->string('password');
            $table->rememberToken(); // 由 rememberToken 方法为用户创建一个 remember_token 字段，用于保存『记住我』的相关信息
            $table->timestamps(); // 由 timestamps 方法创建了一个 created_at 和一个 updated_at 字段
        });
    }

    // 回滚迁移时，down 方法会被调用
    // down 方法会在回滚命令发起时被调用
    // 是 up 方法的逆向操作。在上面的代码中，up 创建了 users 表，那么这里将会通过调用 Schema 的 drop 方法来删除 users 表
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
