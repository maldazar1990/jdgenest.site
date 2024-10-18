<?php

namespace App\Providers;

use App\Users;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        $this->app->bind('path.public', function() {
            return base_path().'/public_html';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') != 'local') {
            URL::forceScheme('https');
        }else{
            $this->app['request']->server->set('HTTP', true);
        }
        Schema::defaultStringLength(191);

    }

    public static function pathsToPublish($provider = null, $group = null)
    {
        return parent::pathsToPublish($provider, $group); // TODO: Change the autogenerated stub
    }
}