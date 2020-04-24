<?php

namespace FreezeWang\LaravelPackageAes;

use FreezeWang\LaravelPackageAes\Middleware\Aes\CheckAesRequestMiddleware;
use Illuminate\Support\ServiceProvider;

class AesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->addMiddlewareAlias('aes.api', CheckAesRequestMiddleware::class);

    }
    # 添加中间件的别名方法
    protected function addMiddlewareAlias($name, $class)
    {
        $router = $this->app['router'];

        if (method_exists($router, 'aliasMiddleware')) {
            return $router->aliasMiddleware($name, $class);
        }

        return $router->middleware($name, $class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
