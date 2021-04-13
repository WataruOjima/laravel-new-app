<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
#use Illuminate\Routing\UrlGenerator;
use DB;
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
        #$url->forceScheme('https');
        // 本番環境以外だった場合、SQLログを出力する
        #if (config('app.env') !== 'production') {
           # DB::listen(function ($query) {
                #\Log::info("Query Time:{$query->time}s] $query->sql");
            #});
          // 本番環境(Heroku)でhttpsを強制する
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }

        // 管理者のID番号を1とする
        //config(['admin_id' => 1]);
    }
}
