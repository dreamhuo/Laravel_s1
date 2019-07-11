<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    use Helpers;

    // 任意 API 控制器中直接使用 $this->errorResponse
    // 示例： return $this->errorResponse(403, '您还没有通过认证', 1003);
    // {'message' : '您还没有通过认证'， 'code' :'1003', 'status_code' : '403'}
    public function errorResponse($statusCode, $message=null, $code=0)
    {
        throw new HttpException($statusCode, $message, null, [], $code);
    }
}