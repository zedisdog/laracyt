<?php
/**
 * Created by zed.
 */
declare(strict_types=1);
namespace Dezsidog\LaraCyt;


use Dezsidog\CytSdk\Sdk;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bind(Sdk::class, function (Application $app, array $config = []) {
            $config = array_merge(config('laracyt'), $config);
            return new Sdk(
                strval($config['create_user']),
                strval($config['key']),
                strval($config['supplier_identity']),
                $app->make('log'),
                strval($config['service_url'])
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
        $router->prefix(config('laracyt.hook.prefix'))
            ->middleware(config('laracyt.hook.middlewares'))
            ->any(config('laracyt.hook.url'), config('laracyt.hook.action'));
    }
}