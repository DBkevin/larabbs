<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //三个判断
        //1.如果用户已经登陆
        //2.并且还未认证
        //3.并访问的还不是email验证的相关 URL或者退出URL
        if($request->user() && 
            !$request->user()->hasVerifiedEmail() &&
            !$request->is('email/*','logout')
        ){
            //根据客户端返回相应的内容
            return $request->expectsJson()
                    ?abort(403,'你的邮箱还没有认证')
                    :redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
