<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\PermissionTransformer;

class PermissionsController extends Controller
{
    public function index()
    {
        // 返回 【所有】 用户通过赋予角色所继承的权限
       $permissions = $this->user()->getAllPermissions();
       // 分类数据是集合，所以我们使用 $this->response->collection 返回数据
       return $this->response->collection($permissions, new PermissionTransformer());
    }
}