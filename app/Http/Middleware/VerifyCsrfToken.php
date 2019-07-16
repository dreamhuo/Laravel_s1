<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;
    /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    // 将 token 加到 cookie 里
    protected function addCookieToResponse($request, $response)
    {
        $config = config('session');

        $response->headers->setCookie(
            new Cookie(
                'dreamToken', $request->session()->token(), $this->availableAt(60 * $config['lifetime']),
                $config['path'], $config['domain'], $config['secure'], false, false, $config['same_site'] ?? null
            )
        );

        return $response;
    }
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
//    protected $except = [
//
//        '/classroom_upload',
//        'wk_upload',
//        'wechat',
//    ];
    // 验证tokens
    protected function tokensMatch($request)
    {
         // 如果当前是 ajax 获取 header 里的 X-CSRF-TOKEN 字段；
         // 然后再判断 session 里 token 与 前端传的 token是否相同
         // 前端方法 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
         $token = $request->ajax() ? $request->header('X-CSRF-TOKEN') : $request->input('_token');
         return $request->session()->token() == $token;
    }

    public function handle($request,\Closure $next){
       // POST 请求一般是登录后，不需要验证
        if($request->method() == 'POST')
        {
            return $next($request);
        }
        return parent::handle($request,$next);
     }
}
