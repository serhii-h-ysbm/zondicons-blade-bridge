<?php

namespace Zondicons;

use BladeSvg\SvgFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ZondiconsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app(SvgFactory::class)->registerBladeTag();

        $this->publishes([
            __DIR__.'/../config/zondicons.php' => config_path('zondicons.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(SvgFactory::class, function () {
            $config = Collection::make(config('blade-svg', []))->merge([
                'spritesheet_path' => base_path('vendor/zondicons/blade-bridge/resources/sprite.svg'),
                'svg_path' => base_path('vendor/zondicons/blade-bridge/resources/icons'),
                'sprite_prefix' => 'zondicon-',
            ])->all();
            return new SvgFactory($config);
        });
    }
}
