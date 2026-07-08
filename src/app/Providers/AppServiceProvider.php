<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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

    /**
     * 画面を表示する前に裏側の準備を整える部屋
     */
    public function boot()
    {
        //

    // 💡 ページネーションの見た目を、シンプルで崩れない「Bootstrap」の形に指定します
    \Illuminate\Pagination\Paginator::useBootstrap();

    }
}
