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
        $df_encode = $request->input(config('aes.encode_name','aes_encode'));
        $df_decode = \aes_decrypt($df_encode, config('aes.signKey'));
        parse_str(trim($df_decode, "\xEF\xBB\xBF"), $df_array);
        //$df_array = json_decode(trim($df_decode, "\xEF\xBB\xBF"), true);
        //将传入的参数遍历写入request
        if ($df_array) {
            array_walk($df_array, function ($value, $key) use ($request) {
                $request->offsetSet($key, $value);
            });
        }
        //标志该次为一次Aes加密的请求,在返回结果的时候判断是否返回密文
        if (config('app.open_aes_response')) $request->offsetSet('isAes', true);
        //移除密文参数,避免加密的时候用上
        $request->offsetUnset('aes_encode');

        return $next($request);
    }
}
