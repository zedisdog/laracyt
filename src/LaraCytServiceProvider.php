<?php
/**
 * Created by zed.
 */
declare(strict_types=1);
namespace Dezsidog\LaraCyt;


use Dezsidog\CytSdk\Sdk;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LaraCytServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Sdk::class, function (Application $app) {
            return new Sdk(
                strval(config('laracyt.create_user')),
                strval(config('laracyt.key')),
                strval(config('laracyt.supplier_identity')),
                $app->make('log'),
                strval(config('laracyt.service_url'))
            );
        });
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        if ($this->app instanceof Application) {
            $this->publishes([
                __DIR__.'/config.php' => config_path('laracyt.php'),
            ]);
        }

        $this->mergeConfigFrom(__DIR__.'/config.php', 'laracyt');

        $router = $this->app->make('router');
        $router->prefix(config('laracyt.hook.prefix', 'api'))
            ->middleware(config('laracyt.hook.middlewares'), 'api')
            ->any(config('laracyt.hook.url'), config('laracyt.hook.action'));
    }
}