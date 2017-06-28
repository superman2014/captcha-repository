<?php

namespace Superman2014\CaptchaRepository;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    protected function setupConfig()
    {

        $config = __DIR__ . '/../config/captcha.php';

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                $config => config_path('captcha.php'),
            ]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('captcha');
        }

        $this->mergeConfigFrom($config, 'captcha');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'captcharepository', function ($app) {
                return new CaptchaRepository($app);
            }
        );

        $this->app->alias('captcharepository', 'Superman2014\CaptchaRepository\CaptchaRepository');
    }

    public function providers()
    {
        return [
            'captcharepository',
        ];
    }
}
