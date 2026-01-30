<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\GameRecord;
use App\Observers\GameRecordObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // 兼容 Dcat Admin 调用 Str::html 不存在的问题
        if (!\Illuminate\Support\Str::hasMacro('html')) {
            \Illuminate\Support\Str::macro('html', function ($value) {
                return new \Illuminate\Support\HtmlString($value);
            });
        }

        // 注册游戏记录观察者，监听游戏记录创建并自动生成返水记录
        // GameRecord::observe(GameRecordObserver::class);
    }
}
