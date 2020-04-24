<?php

namespace App\Http\Middleware\Api\V1\Aes;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckAesResponseMiddleware
{
    /**
     * 验证签名中间件
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //如果使用aes加密,统一加密response结果
        if(request()->isAes){
            return  $response->setContent(aes_encrypt($response->getContent(), config('aes.signKey')));
        }
        return $response;
    }
}
