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
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('kazan/articler');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['config']->package('kazan/articler', __DIR__ . '/../../config');

        $this->app['articler'] = $this->app->share(function($app)
        {
            $repository     = $app['config']->get('articler::repository');
            $parser         = $app['config']->get('articler::parser');
            $cache          = $app['config']->get('articler::cache');
            $configurator   = $app['config']->get('articler::configurator');

            return new Articler(
                $repository($app),
                $parser($app),
                $cache($app),
                $configurator($app)
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('articler');
    }

}
