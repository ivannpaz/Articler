<?php

namespace Kazan\Articler;

use Illuminate\Support\ServiceProvider;

class ArticlerServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('kazan/articles-bin');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('articles-bin', function($app)
        // {
        //     return new Articler(
        //         $app['files'], $app['config'], $app['cache']
        //     );
        // });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('articles-bin');
    }

}
