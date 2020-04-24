<?php

namespace FreezeWang\LaravelPackageAes\Middleware\Aes;

use Exception;
use Closure;

class CheckAesRequestMiddleware
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
        $aes_encode = $request->input(config('common.encode_name','aes_encode'));
        $aes_decode = aes_decrypt($aes_encode, config('common.signKey'));
        parse_str(trim($aes_decode, "\xEF\xBB\xBF"), $df_array);
        //$df_array = json_decode(trim($df_decode, "\xEF\xBB\xBF"), true);
        //将传入的参数遍历写入request
        if ($df_array) {
            array_walk($df_array, function ($value, $key) use ($request) {
                $request->offsetSet($key, $value);
            });
        }
        //标志该次为一次Aes加密的请求,在返回结果的时候判断是否返回密文
        $request->offsetSet('isAes', true);
        //移除密文参数,避免加密的时候用上
        $request->offsetUnset('aes_encode');

        return $next($request);
    }
}
